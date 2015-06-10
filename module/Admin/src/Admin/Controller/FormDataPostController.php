<?php

namespace Admin\Controller;

use ModelModule\Model\Log\LogWriter;
use Application\Controller\SetupAbstractController;
use ModelModule\Model\FormData\FormDataCrudHandler;
use Zend\View\Model\ViewModel;

/**
 * TODO: delete this controller after deleting and migrating all crudHandler objects!!!
 */
class FormDataPostController extends SetupAbstractController
{
    /**
     * Form post checkpoint for insert and update operations on database
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        if (!$this->getServiceLocator()->get('request')->isPost()) {
            return $this->redirect()->toRoute('login');
        }

        $appServiceLoader = $this->recoverAppServiceLoader();

        $formDataCrudHandler = new FormDataCrudHandler();
        $formDataCrudHandler->setInput(array_merge(
            $appServiceLoader->getProperties(),
            array(
                'userDetails'  => $this->recoverUserDetails(),
            )
        ));
        $formDataCrudHandler->setFormCrudHandler($this->params()->fromRoute('form_post_handler'));

        $crudHandlerObject = $formDataCrudHandler->detectCrudHandlerClassMap(
            $appServiceLoader->recoverServiceKey('moduleConfigs', 'formdata_crud_classmap')
        );

        $operation = $this->params()->fromRoute('operation');

        /**
         * @var \ModelModule\Model\FormData\CrudHandlerAbstract $crudHandler
         */
        try {
            if (!class_exists($crudHandlerObject)) {
                throw new \Exception("CrudHandler object does not exist");
            }

            $crudHandler = new $crudHandlerObject();
            $crudHandler->setUrl( $this->url() );

            $request = $this->getRequest();
            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            /* Set form input filter and validate */
            $crudHandler->getForm()->setInputFilter( $crudHandler->getFormInputFilter()->getInputFilter() );
            $crudHandler->getForm()->setBindOnValidate(false);
            $crudHandler->getForm()->setData($post);

            if (!($crudHandler->getForm()->isValid())) {
                throw new \Exception("Form non valido. Verificare i dati inseriti. Se l'errore persiste, contattare l'amministrazione");
            }

            $crudHandler->getFormInputFilter()->exchangeArray( $crudHandler->getForm()->getData() );
            $crudHandler->setEntityManager($appServiceLoader->recoverService('entityManager'));
            $crudHandler->setConnection($appServiceLoader->recoverService('entityManager')->getConnection());
            $crudHandler->setConfigurationsFromDb($appServiceLoader->recoverService('configurations'));
            $crudHandler->setUserDetails($this->recoverUserDetails());

            /* Validate submitted form data (2nd level validation) */
            $formDataValidationError = $crudHandler->validateFormData( $crudHandler->getFormInputFilter() );
            if ( !empty($formDataValidationError) ) {

                $this->layout()->setVariables(
                    array_merge(
                        array(
                            'form' => $crudHandler->getForm(),
                            'formInputFilter' => $crudHandler->getFormInputFilter()->getInputFilter(),
                        ),
                        $crudHandler->setupErrorMessage($formDataValidationError),
                        $crudHandler->setupVariablesForTheView($operation, false),
                        $crudHandler->addVariablesForTheView($crudHandler->getFormInputFilter(), $operation)
                    )
                );

                return $this->renderMessageTemplate($appServiceLoader->recoverServiceKey('configurations', 'template_backend'));
            }

            $crudHandler->getConnection()->beginTransaction();

            if (!method_exists($crudHandler, $operation)) {
                throw new \Exception('The method '.$operation.' does not exist on '.get_class($crudHandler));
            }

            /* Insert or Update */
            try {
                $crudHandler->$operation($crudHandler->getFormInputFilter());

                $crudHandler->getConnection()->commit();

                $this->layout()->setVariables(
                    array_merge(
                        array(
                            'form' => $crudHandler->getForm(),
                            'formInputFilter' => $crudHandler->getFormInputFilter()->getInputFilter(),
                        ),
                        $crudHandler->setupSuccessMessage(),
                        $crudHandler->setupVariablesForTheView($operation, true),
                        $crudHandler->addVariablesForTheView($crudHandler->getFormInputFilter(), $operation)
                    )
                );

                /* Log operation OK */
                $crudHandler->setupLogMethodToExecute($operation, true);

                $crudHandler->setLogWriter(new LogWriter($crudHandler->getConnection()));

                $crudHandler->getLogWriter()->getConnection()->beginTransaction();

                $crudHandler->log();

                $crudHandler->getLogWriter()->getConnection()->commit();

            } catch(\Exception $e) {
                $crudHandler->getConnection()->rollBack();

                $this->layout()->setVariables(
                    array_merge(
                        array(
                            'form'              => $crudHandler->getForm(),
                            'formInputFilter'   => $crudHandler->getFormInputFilter()->getInputFilter(),
                        ),
                        $crudHandler->setupErrorMessage($e->getMessage()),
                        $crudHandler->setupVariablesForTheView($operation, false),
                        $crudHandler->addVariablesForTheView($crudHandler->getFormInputFilter(), $operation)
                    )
                );

                /* Log KO for database query failure */
                $crudHandler->setupLogMethodToExecute($operation, false);

                $crudHandler->setLogWriter(new LogWriter($crudHandler->getConnection()));

                $crudHandler->getLogWriter()->getConnection()->beginTransaction();

                $crudHandler->log($e->getMessage());

                /* Commit */
                $crudHandler->getLogWriter()->getConnection()->commit();
            }

        } catch(\Exception $e) {

            if (isset($crudHandler)) {
                if ($crudHandler->getConnection()) {
                    /* Log KO */
                    $crudHandler->setupLogMethodToExecute($operation, false);

                    $crudHandler->setLogWriter(new LogWriter($crudHandler->getConnection()));

                    $crudHandler->getLogWriter()->getConnection()->beginTransaction();

                    $crudHandler->log($e->getMessage());

                    /* Rollback */
                    $crudHandler->getConnection()->rollBack();
                }

                $this->layout()->setVariables(
                    array_merge(
                        array(
                            'form'              => $crudHandler->getForm(),
                            'formInputFilter'   => $crudHandler->getFormInputFilter()->getInputFilter(),
                        ),
                        $crudHandler->setupErrorMessage($e->getMessage()),
                        $crudHandler->setupVariablesForTheView($operation, false),
                        $crudHandler->addVariablesForTheView($crudHandler->getFormInputFilter(), $operation)
                    )
                );

                return $this->renderMessageTemplate($appServiceLoader->recoverServiceKey('configurations', 'template_backend'));

            } else {
                $this->layout()->setVariables(array(
                    'messageType'   => 'danger',
                    'messageTitle'  => 'Errori verificati',
                    'messageText'   => 'Errore nel percorso di destinazione form (action) o nella configurazione del form',
                ));
            }
        }

        return $this->renderMessageTemplate($appServiceLoader->recoverServiceKey('configurations', 'template_backend'));
    }

        /**
         * @param $template
         * @return ViewModel
         */
        private function renderMessageTemplate($template)
        {
            $this->layout('backend/templates/'.$template.'message.phtml');

            return new ViewModel();
        }
}

<?php

namespace Admin\Controller\Sezioni;

use ModelModule\Model\Modules\ModulesContainer;
use ModelModule\Model\Sezioni\SezioniControllerHelper;
use ModelModule\Model\Sezioni\SezioniForm;
use ModelModule\Model\Sezioni\SezioniFormInputFilter;
use Application\Controller\SetupAbstractController;
use ModelModule\Model\Log\LogWriter;

class SezioniInsertController extends SetupAbstractController
{
    public function indexAction()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        /**
         * @var \Doctrine\DBAL\Connection $connection
         */
        $connection = $em->getConnection();

        $request = $this->getRequest();

        $post = array_merge_recursive( $request->getPost()->toArray(), $request->getFiles()->toArray() );

        if (!($request->isXmlHttpRequest() or $request->isPost())) {
            return $this->redirect()->toRoute('main');
        }

        $inputFilter = new SezioniFormInputFilter();

        $form = new SezioniForm();
        $form->setBindOnValidate(false);
        $form->setInputFilter( $inputFilter->getInputFilter() );
        $form->setData($post);

        $this->initializeAdminArea();

        $userDetails = $this->recoverUserDetails();

        $helper = new SezioniControllerHelper();
        $helper->setConnection($connection);
        $helper->getConnection()->beginTransaction();
        try {

            if (!$form->isValid()) {
                throw new NullException("The form is not valid");
            }

            $inputFilter->exchangeArray( $form->getData() );

            $helper->setLoggedUser($userDetails);
            $lastInsertId = $helper->insert($inputFilter);
            $helper->getConnection()->commit();

            $helper->setLogWriter(new LogWriter($connection));
            $helper->writeLog(array(
                'user_id'       => $userDetails->id,
                'module_id'     => ModulesContainer::contenuti_id,
                'message'       => "Inserita nuova sezione ".$inputFilter->nome. " ID: ".$lastInsertId,
                'type'          => 'info',
                'reference_id'  => $lastInsertId,
                'backend'       => 1,
            ));

            $this->layout()->setVariables(array(
                'messageType'           => 'success',
                'messageTitle'          => 'Sezione inserita correttamente',
                'messageText'           => 'I dati sono stati processati correttamente dal sistema',
                'showLinkResetFormAndShowIt' => 1,
                'backToSummaryLink'     => $this->url()->fromRoute('admin/sezioni-summary', array(
                    'lang'              => $this->params()->fromRoute('languageSelection'),
                    'languageSelection' => $this->params()->fromRoute('languageSelection'),
                )),
                'backToSummaryText'     => "Elenco sezioni",
            ));

            $this->layout()->setTemplate($this->layout()->getVariable('templateDir').'message.phtml');

        } catch(\Exception $e) {

            $helper->getConnection()->rollBack();

            $logWriter = new LogWriter($connection);
            $logWriter->writeLog(array(
                'user_id'       => $userDetails->id,
                'module_id'     => ModulesContainer::contenuti_id,
                'message'       => "Errore inserimento nuova sezione: ".$inputFilter->nome,
                'type'          => 'error',
                'backend'       => 1,
            ));

            $this->layout()->setVariables(array(
                'messageType'           => 'danger',
                'messageTitle'          => 'Errore inserimento nuova sezione',
                'messageText'           => 'Messaggio generato: '.$e->getMessage(),
                'form'                  => $form,
                'formInputFilter'       => $inputFilter->getInputFilter(),
                'messageShowFormLink'   => 1,
                'messageShowForm'       => 'Torna al form di inserimento dati',
            ));

            $this->layout()->setTemplate($this->layout()->getVariable('templateDir').'message.phtml');
        }
    }
}
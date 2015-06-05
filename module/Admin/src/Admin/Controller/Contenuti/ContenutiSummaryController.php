<?php

namespace Admin\Controller\Contenuti;

use ModelModule\Model\Contenuti\ContenutiControllerHelper;
use ModelModule\Model\Contenuti\ContenutiFormSearch;
use ModelModule\Model\Contenuti\ContenutiGetter;
use ModelModule\Model\Contenuti\ContenutiGetterWrapper;
use ModelModule\Model\Languages\LanguagesGetter;
use ModelModule\Model\Languages\LanguagesGetterWrapper;
use ModelModule\Model\Languages\LanguagesFormSearch;
use ModelModule\Model\Sezioni\SottoSezioniGetter;
use ModelModule\Model\Sezioni\SottoSezioniGetterWrapper;
use Application\Controller\SetupAbstractController;
use Zend\Session\Container as SessionContainer;

class ContenutiSummaryController extends SetupAbstractController
{
    public function indexAction()
    {
        $mainLayout = $this->initializeAdminArea();

        $em                     = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $page                   = $this->params()->fromRoute('page');
        $perPage                = $this->params()->fromRoute('perPage');
        $configurations         = $this->layout()->getVariable('configurations');
        $userDetails            = $this->layout()->getVariable('userDetails');
        $userRole               = isset($userDetails->role) ? $userDetails->role : '';
        $userId                 = isset($userDetails->id) ? $userDetails->id : 1;
        $languageSelection      = $this->params()->fromRoute('languageSelection');
        $modulename             = $this->params()->fromRoute('modulename');
        $isAmmTrasparente       = ($modulename!='contenuti') ? 1 : 0;
        //$sessionContainer       = new SessionContainer();

        $helper = new ContenutiControllerHelper();

        try {
            $wrapper = $helper->recoverWrapperRecordsPaginator(
                new ContenutiGetterWrapper(new ContenutiGetter($em)),
                array(
                    'showToAll'             => ($userRole=='WebMaster') ? null : 1,
                    'utente'                => ($userRole=='WebMaster') ? null : $userId,
                    'languageAbbreviation'  => $languageSelection,
                    'isAmmTrasparente'      => $isAmmTrasparente,
                    'orderBy'               => 'contenuti.id DESC',
                ),
                $page,
                $perPage
            );
            $sottoSezioniRecords = $helper->recoverWrapperRecords(
                new SottoSezioniGetterWrapper(new SottoSezioniGetter($em)),
                array(
                    'isAmmTrasparente'      => $isAmmTrasparente,
                    'showToAll'             => ($userRole == 'WebMaster') ? null : 1,
                    'languageAbbreviation'  => $languageSelection,
                )
            );
            $sottoSezioniRecordsForDropDown = $helper->formatSottoSezioniGetterWrapperRecordsForDropdown($sottoSezioniRecords);

            $wrapper->setEntityManager($em);

            $paginatorRecords = $wrapper->addAttachmentsToPaginatorRecords(
                $wrapper->setupRecords(),
                array('orderBy' => '')
            );

            /* Detect form switch language */
            if ((!empty($configurations['isMultiLanguage'])) == 1 and $modulename == 'contenuti') {
                $helper->setLanguagesGetterWrapper(new LanguagesGetterWrapper(new LanguagesGetter($em)));
                $formLanguage = $helper->setupLanguageFormSearch(
                    new LanguagesFormSearch(),
                    array('status' => 1),
                    $languageSelection
                );
            }

            $formSearch = new ContenutiFormSearch();
            $formSearch->addSottosezioni($sottoSezioniRecordsForDropDown);
            $formSearch->addInHome();
            $formSearch->addSubmitButton();
            $formSearch->setData(array(
                array('languageSelection' => $languageSelection),
                array() // TODO: session post form here...
            ));

            $paginator = $wrapper->getPaginator();

            $paginatorRecordsCount = $paginator->getTotalItemCount();

            $this->layout()->setVariables(array(
                'tableTitle'            => ($modulename=='contenuti') ? 'Contenuti' : 'Amministrazione Trasparente',
                'tableDescription'      => $paginatorRecordsCount.' articoli in archivio',
                'paginator'             => $paginator,
                'records'               => $this->formatRecordsToShowOnTable($paginatorRecords),
                'templatePartial'       => 'datatable/datatable_contenuti.phtml',
                'formSearch'            => $formSearch,
                'formLanguage'          => isset($formLanguage) ? $formLanguage : null,
                'columns' => array(
                    "Sezione",
                    "Sotto sezione",
                    "Titolo",
                    'Date',
                    'Inserito da',
                    "&nbsp;",
                    "&nbsp;",
                    "&nbsp;",
                    "&nbsp;",
                    "&nbsp;",
                    ($isAmmTrasparente == 1) ? "&nbsp;" : null,
                ),
            ));

        } catch(\Exception $e) {
            $this->layout()->setVariables(array(
                'messageType'       => 'warning',
                'messageTitle'      => 'Errore verificato',
                'messageText'       => $e->getMessage(),
                'templatePartial'   => 'message.phtml'
            ));
        }

        $this->layout()->setTemplate($mainLayout);
    }

    /**
     * @param array|null $records
     * @return array
     */
    private function formatRecordsToShowOnTable($records)
    {
        $lang                   = $this->params()->fromRoute('lang');
        $languageSelection      = $this->params()->fromRoute('languageSelection');
        $modulename             = $this->params()->fromRoute('modulename');
        $isAmmTrasparente       = ($modulename!='contenuti') ? 1 : 0;

        $arrayToReturn = array();
        if ($records) {
            foreach($records as $key => $row) {

                if ($row['attivo']==1) {
                    $enableDisableLink = $this->url()->fromRoute('admin/contenuti-enabledisable', array(
                        'lang'              => $lang,
                        'languageSelection' => $languageSelection,
                        'id'                => $row['id'],
                        'action'            => 'disable',
                    ));
                } else {
                    $enableDisableLink = $this->url()->fromRoute('admin/contenuti-enabledisable', array(
                        'lang'              => $lang,
                        'languageSelection' => $languageSelection,
                        'id'                => $row['id'],
                        'action'            => 'enable',
                    ));
                }

                /* Home page put \ remove link */
                if ($row['home']==1) {
                    $homePutRemoveLink = $this->url()->fromRoute('admin/contenuti-homeputremove', array(
                            'lang'          => $lang,
                            'action'        => 'remove',
                            'id'            => $row['id']
                        )
                    );
                } else {
                    $homePutRemoveLink = $this->url()->fromRoute('admin/contenuti-homeputremove', array(
                        'lang'          => $lang,
                        'action'        => 'put',
                        'id'            => $row['id']
                    ));
                }

                if ($isAmmTrasparente==1) {
                    $tableButton = array(
                        'type' => 'tableButton',
                        'href' => $this->url()->fromRoute('admin/amministrazione-trasparente-tabella', array(
                            'lang'              => $lang,
                            'languageSelection' => $languageSelection,
                            'id'                => $row['id']
                        )),
                        'attachmentsFilesCount' => isset($row['attachments']) ? count($row['attachments']) : 0,
                    );
                }

                $arrayToReturn[] = array(
                    $row['nomeSezione'],
                    $row['nomeSottosezione'],
                    $row['titolo'],
                    'Inserimento: '.$row['dataInserimento']."<br><br>Scadenza: ".$row['dataScadenza'],
                    $row['name'].' '.$row['surname'],
                    /* Enable \ Disable button */
                    array(
                        'type'      => $row['attivo']==1 ? 'activeButton' : 'disableButton',
                        'href'      => $enableDisableLink,
                        'value'     => $row['attivo'],
                        'title'     => $row['attivo']==1 ? 'Nascondi contenuto sul sito' : 'Mostra contenuto sul sito',
                    ),
                    /* Edit button */
                    array(
                        'type' => 'updateButton',
                        'href' => $this->url()->fromRoute('admin/contenuti-form', array(
                                'lang'              => $lang,
                                'modulename'        => $modulename,
                                'languageSelection' => $languageSelection,
                                'id'                => $row['id'],
                                'previouspage'      => $this->params()->fromRoute('page'),
                            )
                        ),
                        'title' => 'Modifica contenuto'
                    ),
                    /* Delete button */
                    array(
                        'type' => 'deleteButton',
                        'href' => $this->url()->fromRoute('admin/contenuti-operations', array(
                                'lang'          => $this->params()->fromRoute('lang'),
                                'action'        => 'delete',
                                'id'            => $row['id']
                            )
                        ),
                        'data-id' => $row['id'],
                        'title'   => 'Elimina contenuto'
                    ),
                    /* Homepage button */
                    array(
                        'type'      => $row['home']==1 ? 'homepagePutButton' : 'homepageDelButton',
                        'href'      => $homePutRemoveLink,
                        'value'     => $row['home']==1 ? 'homepagePutButton' : 'homepageDelButton',
                    ),
                    /* Attachment button */
                    array(
                        'type' => 'attachButton',
                        'href' => $this->url()->fromRoute('admin/attachments-summary', array(
                                'lang'              => $lang,
                                'module'            => 'contenuti',
                                'referenceId'       => $row['id'],
                            )
                        ),
                        'attachmentsFilesCount' => isset($row['attachments']) ? count($row['attachments']) : 0,
                    ),
                    /* Tabella gestione "tabellare" amm. trasparente */
                    !empty($tableButton) ? $tableButton : null,
                );

            }
        }

        return $arrayToReturn;
    }
}
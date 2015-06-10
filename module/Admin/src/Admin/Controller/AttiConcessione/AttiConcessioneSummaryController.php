<?php

namespace Admin\Controller\AttiConcessione;

use ModelModule\Model\AttiConcessione\AttiConcessioneControllerHelper;
use ModelModule\Model\AttiConcessione\AttiConcessioneGetter;
use ModelModule\Model\AttiConcessione\AttiConcessioneGetterWrapper;
use ModelModule\Model\Users\Settori\UsersSettoriGetter;
use ModelModule\Model\Users\Settori\UsersSettoriGetterWrapper;
use Application\Controller\SetupAbstractController;
use ModelModule\Model\AttiConcessione\AttiConcessioneFormSearch;

class AttiConcessioneSummaryController extends SetupAbstractController
{
    public function indexAction()
    {
        $mainLayout = $this->initializeAdminArea();

        $page       = $this->params()->fromRoute('page');
        $em         = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        try {

            $helper = new AttiConcessioneControllerHelper();
            $yearsRecords = $helper->recoverWrapperRecords(
                new AttiConcessioneGetterWrapper(new AttiConcessioneGetter($em)),
                array(
                    'fields' => 'DISTINCT(atti.anno) AS year',
                    'orderBy' => 'atti.id DESC'
                ),
                $page,
                null
            );
            $wrapperArticoli = $helper->recoverWrapperRecordsPaginator(
                new AttiConcessioneGetterWrapper(new AttiConcessioneGetter($em)),
                array('orderBy' => 'atti.id DESC'),
                $page,
                null
            );
            $settoriRecords = $helper->recoverWrapperRecords(
                new UsersSettoriGetterWrapper(new UsersSettoriGetter($em)),
                array('orderBy' => 'settore.nome')
            );

            $yearsForDropdown = $helper->formatYears($yearsRecords);

            $settoriForDropDown = $helper->formatForDropwdown($settoriRecords, 'id', 'nome');

            $form = new AttiConcessioneFormSearch();
            $form->addAnno($yearsForDropdown);
            $form->addMainElements();
            $form->addUfficio($settoriForDropDown);
            $form->addSubmitSearchButton();
            $form->addResetButton();

            $paginator          = $wrapperArticoli->getPaginator();
            $paginatorItemCount = $paginator->getTotalItemCount();
            $paginatorRecords   = $this->formatArticoliRecords($wrapperArticoli->setupRecords());

            $formSearch = new AttiConcessioneFormSearch();
            $formSearch->addMainElements();
            $formSearch->addAnno($yearsForDropdown);
            $formSearch->addUfficio($settoriForDropDown);
            $formSearch->addSubmitSearchButton();

            if ( empty($paginatorRecords) ) {
                $this->layout()->setVariables(array(
                        'messageType'           => 'warning',
                        'messageTitle'          => 'Nessun atto di concessione presente',
                        'messageText'           => 'Nessun atto di concessione presente in archivio',
                        'showBreadCrumb'        => 1,
                        'dataTableActiveTitle'  => 'Atti di concessione',
                        'templatePartial'       => 'message.phtml',
                    )
                );

                $this->layout()->setTemplate($mainLayout);

                return true;
            }

            $this->layout()->setVariables(array(
                    'tableTitle'        => 'Atti di concessione',
                    'tableDescription'  => $paginatorItemCount." atti in archivio",
                    'tablesetter'       => 'atti-concessione',
                    'formSearch'        => $formSearch,
                    'columns'           => array(
                        "Ufficio-Responsabile del Servizio - Responsabile del Procedimento",
                        "Num / Anno",
                        "CF / P. IVA Beneficiario",
                        "Modalità Assegnazione",
                        "Importo",
                        "Norma o Titolo a base dell'attribuzione",
                        "Date",
                        //"&nbsp;",
                        "&nbsp;",
                        "&nbsp;",
                        "&nbsp;",
                    ),
                    'paginator'         => $paginator,
                    'records'           => $paginatorRecords,
                    'templatePartial'   => 'datatable/datatable_atti_concessione.phtml'
                )
            );

            $this->layout()->setTemplate($mainLayout);

        } catch(\Exception $e) {

        }
    }

        /**
         * @param array $records
         * @return array
         */
        private function formatArticoliRecords($records)
        {
            $arrayToReturn = array();

            if ($records) {
                foreach($records as $key => $row) {

                    if(isset($row['responsabile'])) {
                        $responsabile = $row['responsabile'];
                    } elseif (isset($row['nomeResp'])) {
                        $responsabile = $row['nomeResp'];
                    }

                    if (!isset($responsabile)) {
                        $responsabile = null;
                    }

                    $arrayToReturn[] = array(

                        (isset($responsabile))  ?
                            $row['nomeSezione'].'. <br><br>'.$responsabile
                            :
                            $row['nomeSezione'],

                        $row['progressivo']." / ".$row['anno'],
                        $row['beneficiario'],
                        $row['nomemodAssegnazione'],
                        $row['importo'],
                        $row['titolo'],
                        '<strong>Data inserimento:</strong> '.$row['dataInserimento'].' <br><br><strong>Scadenza:</strong> '.$row['scadenza'].'<br><br> <strong>Inserito da:</strong> '.$row['name'].' '.$row['surname'],
                        /*
                        array(
                            'type'      => ($row['attivo']!=0) ? 'toDisable' : 'toActive',
                            'href'      => '?active=&amp;id='.$row['id'],
                            'value'     => $row['attivo'],
                            'title'     => 'Attiva \ Disattiva'
                        ),
                        */
                        array(
                            'type'      => 'updateButton',
                            'href'      => $this->url()->fromRoute('admin/atti-concessione-form', array('lang' => 'it', 'id' => $row['id']) ),
                            'title'     => 'Modifica'
                        ),
                        array(
                            'type'      => 'deleteButton',
                            'href'      => '#',
                            'title'     => 'Elimina',
                            'data-id'   => $row['id'],
                        ),
                        array(
                            'type'      => 'attachButton',
                            'href'      => $this->url()->fromRoute('admin/attachments-summary', array(
                                'lang'          => 'it',
                                'module'        => 'atti-concessione',
                                'referenceId'   => $row['id']
                            )),
                            'title'     => 'Gestione allegati',
                        ),
                    );
                }
            }

            return $arrayToReturn;
        }
}
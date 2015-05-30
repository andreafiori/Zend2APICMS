<?php

namespace Admin\Controller\Sezioni;

use ModelModule\Model\Sezioni\SezioniControllerHelper;
use ModelModule\Model\Sezioni\SezioniGetter;
use ModelModule\Model\Sezioni\SezioniGetterWrapper;
use ModelModule\Model\Languages\LanguagesGetter;
use ModelModule\Model\Languages\LanguagesGetterWrapper;
use ModelModule\Model\Languages\LanguagesFormSearch;
use Application\Controller\SetupAbstractController;

class SezioniPositionsController extends SetupAbstractController
{
    public function indexAction()
    {
        $mainLayout = $this->initializeAdminArea();

        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $configurations = $this->layout()->getVariable('configurations');

        $languageSelection = $this->params()->fromRoute('languageSelection');

        $helper = new SezioniControllerHelper();
        $helper->setSezioniGetterWrapper(new SezioniGetterWrapper(new SezioniGetter($em)));

        $wrapper = $helper->recoverWrapper(
            $helper->getSezioniGetterWrapper(),
            array(
                'fields'                => 'sezioni.id, sezioni.nome, sezioni.colonna, sezioni.posizione',
                'blocco'                => 1,
                'attivo'                => 1,
                'languageAbbreviation'  => $languageSelection,
                'orderBy'               => 'sezioni.posizione'
            )
        );

        $isMultiLanguage = !empty($configurations['isMultiLanguage']);
        if ($isMultiLanguage==1) {
            $helper->setLanguagesGetterWrapper(new LanguagesGetterWrapper(new LanguagesGetter($em)));

            $formLanguage = $helper->setupLanguageFormSearch(
                new LanguagesFormSearch(),
                array('status' => 1),
                $languageSelection
            );
        }

        $this->layout()->setVariables(array(
            'records'           => $wrapper->formatRecordsPerColumn($wrapper->getRecords()),
            'templatePartial'   => 'sezioni/sezioni-posizioni.phtml',
            'formLanguage'      => $formLanguage,
        ));

        $this->layout()->setTemplate($mainLayout);
    }
}
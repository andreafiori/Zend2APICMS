<?php

namespace Admin\Controller\AlboPretorio;

use DOMPDFModule\View\Model\PdfModel;
use Zend\View\Model\ViewModel;
use Application\Controller\SetupAbstractController;
use Admin\Model\AlboPretorio\AlboPretorioArticoliGetter;
use Admin\Model\AlboPretorio\AlboPretorioArticoliGetterWrapper;

/**
 * @author Andrea Fiori
 * @since  22 December 2014
 */
class AlboPretorioRelataPdfController extends SetupAbstractController
{
    /**
     * @return PdfModel
     */
    public function indexAction()
    {
        $records = $this->getArticle( $this->params()->fromRoute('id') );

        $pdf = new PdfModel();
        $pdf->setOption('filename',         'albo-pretorio-relata-'.$records[0]['id']);
        $pdf->setOption('paperSize',        'a4');
        $pdf->setOption('paperOrientation', 'landscape');
        $pdf->setVariables(array(
            'record' => $records[0]
        ));
        return $pdf;
    }

        /**
         * @param int $id
         * @return AlboPretorioArticoliGetterWrapper
         */
        private function getArticle($id)
        {
            $wrapper = new AlboPretorioArticoliGetterWrapper(
                new AlboPretorioArticoliGetter($this->getServiceLocator()->get('doctrine.entitymanager.orm_default'))
            );
            $wrapper->setInput(
                array(
                    'id'    => $id,
                    'limit' => 1
                )
            );
            $wrapper->setupQueryBuilder();

            return $wrapper->getRecords();
        }
}
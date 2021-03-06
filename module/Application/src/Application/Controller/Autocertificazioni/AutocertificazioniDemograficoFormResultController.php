<?php

namespace Application\Controller\Autocertificazioni;

use Application\Controller\SetupAbstractController;
use DOMPDFModule\View\Model\PdfModel;
use ModelModule\Model\Autocertificazioni\Demografico\DichiarazioneAttoNotorieta1Form;
use ModelModule\Model\Autocertificazioni\Demografico\DichiarazioneAttoNotorieta2Form;
use ModelModule\Model\Autocertificazioni\Demografico\DichiarazioneResidenzaForm;
use ModelModule\Model\Autocertificazioni\Demografico\DichiarazioneResidenzaFormInputFilter;

/**
 * Autocertificazioni forms demografico results
 */
class AutocertificazioniDemograficoFormResultController extends SetupAbstractController
{
    /**
     * Dichiarazione residenza 1 form
     */
    public function dichiarazioneresidenza1Action()
    {

    }

    /**
     * Dichiarazione residenza 2 form
     */
    public function dichiarazioneresidenza2Action()
    {

    }

    /**
     * Dichiarazione atto notorieta 1 form result
     *
     * @return PdfModel
     */
    public function dichiarazioneattonotorieta1Action()
    {
        $mainLayout = $this->initializeFrontendWebsite();

        $request = $this->getRequest();

        $post = array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());

        if ( !$request->isPost() ) {
            return $this->redirect()->toRoute('main');
        }

        $inputFilter = new DichiarazioneResidenzaFormInputFilter();

        $form = new DichiarazioneAttoNotorieta1Form();
        $form->setBindOnValidate(false);
        $form->setInputFilter( $inputFilter->getInputFilter() );
        $form->setData($post);

        if ( !$form->isValid() ) {

            $this->layout()->setVariables(array(
                'form'            => $form,
                'form_errors'     => array(),
                'templatePartial' => 'autocertificazioni/forms/demografico/dichiarazione-sostitutiva-notorieta1-form.phtml',
            ));

            $this->layout()->setTemplate($mainLayout);

        } else {

            $tempalteDir = $this->layout()->getVariable('templateDir');

            $inputFilter->exchangeArray( $form->getData() );

            $pdf = new PdfModel();
            /* $pdf->setOption('filename',         'dichiarazione-atto-notorieta-'.date("dmYHis")); */
            $pdf->setOption('paperSize',        'a4');
            $pdf->setOption('paperOrientation', 'landscape');
            $pdf->setVariables( array('records' => $inputFilter) );
            $pdf->setTemplate($tempalteDir.'autocertificazioni/forms/demografico/export/dichiarazione-sostitutiva-notorieta1-pdf.phtml');

            return $pdf;
        }
    }

    /**
     * Dichiarazione atto notorieta 2 form result
     *
     * @return PdfModel
     */
    public function dichiarazioneattonotorieta2Action()
    {

    }

    public function dichiarazioneespatriominoreAction()
    {

    }
}
<?php

namespace Admin\Model\ContrattiPubblici\SceltaContraente;

use Zend\Form\Form;

/**
 * @author Andrea Fiori
 * @since 16 August 2014
 */
class SceltaContraenteForm extends Form
{
    /**
     * @inheritdoc
     */
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        
        $this->add(array(
                        'name' => 'nomeScelta',
                        'type' => 'Text',
                        'options' => array( 'label' => '* Nome' ),
                        'attributes' => array(
                                        'id' => 'nome_scelta',
                                        'title' => 'Inserisci scelta contraente',
                                        'required' => 'required'
                        ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array("class" => 'hiddenField')
        ));
    }
}
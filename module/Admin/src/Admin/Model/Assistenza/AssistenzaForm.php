<?php

namespace Admin\Model\Assistenza;

use Zend\Form\Form;

/**
 * @author Andrea Fiori
 * @since  14 May 2014
 */
class AssistenzaForm extends Form
{
    /**
     * @param string $name
     */
    public function __construct($name = '')
    {
        parent::__construct($name);
        
        $this->add(array( 
            'name' => 'oggetto', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'placeholder' => 'Oggetto del problema',
                'title' => "Inserisci l'oggetto del problema",
                'required' => 'required',
            ), 
            'options' => array( 
                'label' => 'Oggetto', 
            ), 
        ));
        
        $this->add(array( 
            'name' => 'descrizione', 
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'placeholder' => 'Inserisci descrizione...',
                'title' => 'Inserisci descrizione...', 
                'required' => 'required',
                'rows' => 8,
                'cols' => 35,
            ),
            'options' => array( 
                'label' => 'Descrizione', 
            ),
        ));
        /*
        $this->add(array(
            'name' => 'send',
            'type'  => 'submit',
            'attributes' => array(
                'label' => '&nbsp;',
                'value' => 'Invia',
            ))
        );
        */
    }
}
<?php

namespace ModelModule\Model\Contenuti;

use Zend\Form\Form;

/**
 * Contenuti Form Search
 */
class ContenutiFormSearch extends Form
{
    /**
     * @inheritdoc
     */
    public function __construct($name = null, $options = null)
    {
        parent::__construct($name);

        $this->add(array(
            'type' => 'Text',
            'name' => 'testo',
            'attributes' => array(
                'placeholder'   => 'Testo...',
                'title'         => 'Inserisci testo',
                'id'            => 'testo',
            ),
            'options' => array(
                'label' => 'Testo',
            )
        ));

        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));
    }

    public function addAnno()
    {
        $this->add(array(
            'name' => 'anno',
            'type' => 'Text',
            'options' => array( 'label' => '* Anno' ),
            'attributes' => array(
                'title'     => 'Anno di riferimento',
                'id'        => 'anno',
                'maxlength' => 4,
            )
        ));
    }

    public function addCheckExpired()
    {
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'searchSubsection',
            'required' => false,
            'options' => array(
                'label' => 'Cerca nelle sottosezioni',
                'use_hidden_element' => false,
                'checked_value'      => 1,
                'unchecked_value'    => 0
            ),
            'attributes' => array(
                'id' => 'searchSubsection'
            )
        ));
    }

    /**
     * @param array $sezioni
     */
    public function addSezioni($sezioni)
    {
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'sezioni',
            'attributes' => array(
                'title' => 'Seleziona sezioni',
                'id'    => 'sezioni'
            ),
            'options' => array(
                'label' => 'Sezioni',
                'empty_option' => 'Seleziona',
                'value_options' => $sezioni,
            )
        ));
    }

    /**
     * @param array $sottoSezioni
     */
    public function addSottosezioni($sottoSezioni)
    {
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'sottosezioni',
            'attributes' => array(
                'title' => 'Seleziona sottosezioni',
                'id'    => 'sottosezioni'
            ),
            'options' => array(
                'label' => 'Sottosezioni',
                'empty_option' => 'Seleziona',
                'value_options' => $sottoSezioni,
            )
        ));
    }

    /**
     * @param array $userRecords
     */
    public function addUsers(array $userRecords)
    {
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'utente',
            'options' => array(
                'label' => '* Utente',
                'empty_option' => 'Seleziona',
                'value_options' => $userRecords,
            ),
            'attributes' => array(
                'title'     => 'Seleziona utente',
                'id'        => 'utente',
            )
        ));
    }

    public function addInHome()
    {
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'inhome',
            'options' => array(
                'label'              => 'in home page',
                'use_hidden_element' => false,
                'checked_value'      => 1,
                'unchecked_value'    => 0,
            ),
            'required' => false,
            'attributes' => array(
                'id'    => 'inhome',
                'title' => "Presente in home page"
            )
        ));
    }

    public function addSubmitButton()
    {
        $this->add(array(
                'name' => 'search',
                'type'  => 'submit',
                'attributes' => array(
                    'label' => '&nbsp;',
                    'title' => "Premi per avviare la ricerca",
                    'value' => 'Cerca',
                    'id'    => 'submit',
                ))
        );
    }

    public function addResetButton()
    {
        $this->add(array(
                'name' => 'reset',
                'type'  => 'submit',
                'attributes' => array(
                    'label' => '&nbsp;',
                    'title' => "Premi per resettare la ricerca",
                    'value' => 'Reset',
                    'id'    => 'reset',
                    'type'  => 'reset',
                ))
        );
    }
}

<?php

namespace ModelModule\Model\Contacts;

use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Element;

class ContactsForm extends Form 
{
    /**
     * @inheritdoc
     */
    public function __construct($name = null, $options = null)
    {
        parent::__construct($name);

        $this->add(array( 
            'name' => 'nome', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'placeholder' => 'Nome...',
                'title'     => 'Inserisci nome',
                'required'  => 'required',
                'id'        => 'nome',
                'maxlength' => 200,
            ),
            'options' => array( 
                'label' => '* Nome',
            ), 
        ));
 
        $this->add(array( 
            'name' => 'cognome', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'placeholder'   => 'Cognome...',
                'title'         => 'Inserisci cognome',
                'required'      => 'required',
                 'id'           => 'cognome',
                'maxlength'     => 200,
            ),
            'options' => array( 
                'label' => '* Cognome',
            ), 
        )); 
        
        $this->add(array( 
            'name' => 'email', 
            'type' => 'Zend\Form\Element\Email',
            'attributes' => array( 
                'placeholder'   => 'Email...',
                'title'         => 'Inserisci indirizzo email', 
                'required'      => 'required',
                'id'            => 'email',
                'maxlength'     => 200,
            ), 
            'options' => array(
                'label' => '* Email',
            ),
        ));
 
        $this->add(array( 
            'name' => 'messaggio', 
            'type' => 'Zend\Form\Element\Textarea', 
            'attributes' => array(
                'placeholder'   => 'Inserisci il messagio...',
                'title'         => 'Inserisci il messagio', 
                'required'      => 'required',
                'rows'          => 8,
                'cols'          => 35,
                'id'            => 'messaggio',
                'maxlength'     => 200,
            ), 
            'options' => array(
                'label' => '* Messaggio',
            ), 
        ));
        
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));
    }

    public function addCaptcha()
    {
        $dumb = new Captcha\Dumb();
        $dumb->setLabel('Copia e incolla la seguente stringa:');

        $captcha = new Element\Captcha('captcha');
        $captcha->setCaptcha($dumb)->setLabel('Captcha');

        $this->add($captcha);
    }

    public function addSubmitButton()
    {
        $this->add(array(
                'name' => 'send',
                'type'  => 'submit',
                'attributes' => array(
                    'label' => '&nbsp;',
                    'value' => 'Invia',
                    'id'    => 'send'
                ))
        );
    }
}
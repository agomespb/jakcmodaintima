<?php

namespace AGUser\Form;

use Zend\Form\Form;

class Login  extends Form
{
    public function __construct($name = null, $options = array()) {
        
        parent::__construct('Login', $options);
        
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-signin');

        $email = new \Zend\Form\Element\Text("email");
        $email->setAttribute('class', "form-control")
              ->setAttribute('required', true)
              ->setAttribute('placeholder','Entre com o Email');
        $this->add($email);
       
        $password = new \Zend\Form\Element\Password("password");
        $password->setAttribute('class', "form-control")
                 ->setAttribute('required', true)
                 ->setAttribute('placeholder','Entre com a senha');
        $this->add($password);
        
        $this->add(array(
            'name' => 'submit',
            'type'=>'Zend\Form\Element\Submit',
            'attributes' => array(
                'value'=>'Autenticar',
                'class' => 'btn btn-lg btn-primary btn-block'
            )
        ));
    }
}

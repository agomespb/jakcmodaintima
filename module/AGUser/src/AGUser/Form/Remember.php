<?php

namespace AGUser\Form;

use Zend\Form\Form;

class Remember  extends Form
{
    public function __construct($name = null, $options = array()) {
        
        parent::__construct('user', $options);
        
        $this->setInputFilter(new \AGUser\Filter\RememberFilter());
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-signin');
        $this->setAttribute('role', 'form');        
       
        $email = new \Zend\Form\Element\Text("email");
        $email->setAttribute('class', "input-text")
              ->setAttribute('placeholder','Email Válido')
              ->setAttribute('required', true);
        $this->add($email);
        
        $this->add(array(
            'name' => 'submit',
            'type'=>'Zend\Form\Element\Submit',
            'attributes' => array(
                'value'=>'Enviar',
                'class' => 'button-alt'
            )
        ));
    }
}

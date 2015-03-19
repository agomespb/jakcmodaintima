<?php

namespace AGUser\Form;

use Zend\Form\Form;

class NewPassWord  extends Form
{
    public function __construct($name = null, $options = array()) {
        
        parent::__construct('user', $options);
        
        $this->setInputFilter(new \AGUser\Filter\NewPassWordFilter());
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');        
        
        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $csrf = new \Zend\Form\Element\Csrf("security");
        $this->add($csrf);
        
        $password = new \Zend\Form\Element\Password("password");
        $password->setAttribute('class', "form-control input-lg")
                 ->setAttribute('required', true)
                 ->setAttribute('placeholder','Senha para Acesso');
        $this->add($password);
        
        $confirmation = new \Zend\Form\Element\Password("confirmation");
        $confirmation->setAttribute('class', "form-control input-lg")
                     ->setAttribute('required', true)
                     ->setAttribute('placeholder','Confirmar a Senha');
        $this->add($confirmation);
        
        $this->add(array(
            'name' => 'submit',
            'type'=>'Zend\Form\Element\Submit',
            'attributes' => array(
                'value'=>'Salvar',
                'class' => 'btn btn-primary btn-block btn-lg'
            )
        ));
    }
}

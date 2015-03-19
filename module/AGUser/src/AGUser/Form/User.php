<?php

namespace AGUser\Form;

use Zend\Form\Form;

class User  extends Form
{
    public function __construct($name = null, $options = array(), array $roles = null) {
        
        parent::__construct('user', $options);
        
        $this->setInputFilter(new \AGUser\Filter\UserFilter());
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-signin');
        $this->setAttribute('role', 'form');        
        
        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);
        
        $nome = new \Zend\Form\Element\Text("nome");
        $nome->setAttribute('class', "input-text")
             ->setAttribute('id','NomeCompleto')
             ->setAttribute('placeholder','Nome Completo')
             ->setAttribute('required', true);
        $this->add($nome);
       
        $email = new \Zend\Form\Element\Text("email");
        $email->setAttribute('class', "input-text")
              ->setAttribute('id','EmailValido')
              ->setAttribute('placeholder','Email Válido')
              ->setAttribute('required', true);
        $this->add($email);
       
        $password = new \Zend\Form\Element\Password("password");
        $password->setAttribute('class', "input-text")
                 ->setAttribute('id', 'PassWord')
                 ->setAttribute('required', true)
                 ->setAttribute('placeholder','Senha para Acesso');
        $this->add($password);
        
        $confirmation = new \Zend\Form\Element\Password("confirmation");
        $confirmation->setAttribute('class', "input-text")
                     ->setAttribute('id', 'PassWordConfirmation')
                     ->setAttribute('required', true)
                     ->setAttribute('placeholder','Confirmar a Senha');
        $this->add($confirmation);
        
        $role = new \Zend\Form\Element\Select();
        $role->setName("role")
             ->setAttribute('required', true)
             ->setAttribute('id', 'RoleSelect')
             ->setAttribute('class', "select")
             ->setOptions(array('value_options' => $roles));
        $this->add($role);        
        
        $csrf = new \Zend\Form\Element\Csrf("security");
        $this->add($csrf);
        
        $this->add(array(
            'name' => 'submit',
            'type'=>'Zend\Form\Element\Submit',
            'attributes' => array(
                'value'=>'Salvar',
                'class' => 'button-alt'
            )
        ));
    }
}

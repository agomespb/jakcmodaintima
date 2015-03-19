<?php

namespace AGAcl\Form;

use Zend\Form\Form,
    Zend\Form\Element\Select;

class Privilege extends Form {
    
    protected $roles;
    protected $resources;

    public function __construct($name = null, array $roles = null, array $resources = null) {
        
        parent::__construct($name);
        
        $this->roles = $roles;
        $this->resources = $resources;
        
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');  
        
        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $nome = new \Zend\Form\Element\Text("nome");
        $nome->setAttribute('class', "form-control input-lg")
             ->setAttribute('placeholder', "Nome do privilégio");
        $this->add($nome);
        
        $role = new Select();
        $role->setName("role")
             ->setAttribute('class', "form-control input-lg")
             ->setOptions(array('value_options' => $roles));
        $this->add($role);
        
        $resource = new Select();
        $resource->setAttribute('class', "form-control input-lg")
                 ->setName("resource")
                 ->setOptions(array('value_options' => $resources));
        $this->add($resource);
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' => 'btn btn-primary btn-block btn-lg'
            )
        ));
    
        
    }

}

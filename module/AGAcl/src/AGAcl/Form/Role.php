<?php

namespace AGAcl\Form;

use Zend\Form\Form,
    Zend\Form\Element\Select;

class Role extends Form {
    
    protected $parent;

    public function __construct($name = null, array $parent = null) {
        parent::__construct('roles');
        $this->parent  = $parent;
        
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');
        
        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);

        $nome = new \Zend\Form\Element\Text("nome");
        $nome->setAttribute('placeholder', "Entre com o nome")
             ->setAttribute('class', "form-control input-lg");
                
        $this->add($nome);
        
        $allParent = array_merge(array(0=>'Nenhum'),$this->parent);
        $parent = new Select();
        $parent->setName("parent")
               ->setOptions(array('value_options' => $allParent))
               ->setAttribute('class', "form-control input-lg")
               ->setAttribute('id', "parent");
        $this->add($parent);
        
        $isAdmin = new \Zend\Form\Element\Checkbox("isAdmin");
        $this->add($isAdmin);
        
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

<?php

namespace AGUser\Form;

use Zend\Form\Form;

class Address  extends Form
{
    private $estados;

    public function __construct($options = array(), $estados = array()) {
        
        parent::__construct('address', $options);
        
        $this->estados = $estados;
        
        $this->setInputFilter(new \AGUser\Filter\AddressFilter());
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-signin');
        $this->setAttribute('role', 'form');        
        
        $id = new \Zend\Form\Element\Hidden('id');
        $this->add($id);
        
        $this->setLogradouro();
        $this->setNumero();
        $this->setComplemento();
        $this->setBairro();
        $this->setCidade();
        $this->setEstado();
        $this->setCep();
        $this->setSubmit();
        
        $csrf = new \Zend\Form\Element\Csrf("security");
        $this->add($csrf);
    }
    
    private function setLogradouro(){
        $logradouro = new \Zend\Form\Element\Text("logradouro");
        $logradouro->setAttribute('class', "input-text")
             ->setAttribute('id','Logradouro')
             ->setAttribute('placeholder','Rua / Av. / Trav. / ...')
             ->setAttribute('required', true);
        $this->add($logradouro);        
    }
    
    private function setNumero(){
        $numero = new \Zend\Form\Element\Text("numero");
        $numero->setAttribute('class', "input-text")
               ->setAttribute('id','Numero')
               ->setAttribute('placeholder','Número');
        $this->add($numero);        
    }
    
    private function setComplemento(){
        $complemento = new \Zend\Form\Element\Text("complemento");
        $complemento->setAttribute('class', "input-text")
             ->setAttribute('id','Complemento')
             ->setAttribute('placeholder','Fica próximo a ...');
        $this->add($complemento);        
    }    

    private function setBairro(){
        $bairro = new \Zend\Form\Element\Text("bairro");
        $bairro->setAttribute('class', "input-text")
             ->setAttribute('id','Bairro')
             ->setAttribute('placeholder','Bairro')
             ->setAttribute('required', true);
        $this->add($bairro);        
    }

    private function setCidade(){
        $cidade = new \Zend\Form\Element\Text('cidade');
        $cidade->setAttribute('class', 'input-text')
             ->setAttribute('id','Cidade')
             ->setAttribute('placeholder','Cidade')
             ->setAttribute('required', true);
        $this->add($cidade);        
    }

    private function setEstado(){
        $estado = new \Zend\Form\Element\Select();
        $estado->setName("estado")
             ->setAttribute('required', true)
             ->setAttribute('class', "select")
             ->setAttribute('id','Estado')
             ->setOptions(array('value_options' => $this->estados));
        $this->add($estado);        
    }
    
    private function setCep(){
        $cep = new \Zend\Form\Element\Text('cep');
        $cep->setAttribute('class', 'input-text')
             ->setAttribute('id','Cep')
             ->setAttribute('placeholder','CEP')
             ->setAttribute('required', true);
        $this->add($cep);        
    }    
    
    private function setSubmit(){
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

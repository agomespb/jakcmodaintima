<?php

namespace AGUser\Filter;

use Zend\InputFilter\InputFilter;

class AddressFilter extends InputFilter {

    public function __construct() {

        $this->setUserFilterLogradouro();
        $this->setUserFilterNumero();
        $this->setUserFilterComplemento();
        $this->setUserFilterBairro();
        $this->setUserFilterCidade();
        $this->setUserFilterEstado();
        $this->setUserFilterCep();
    }
    
    private function setUserFilterLogradouro(){
        
        $this->add(array(
            'name'=>'logradouro',
            'required'=>true,
            'filters' => array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'=>'NotEmpty',
                    'options'=>array(
                        'messages'=>array('isEmpty'=>'Não pode estar em branco')
                    )
                ),
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 50,
                        'messages' => array(
                            'stringLengthTooShort' => 'Mínimo aceito: 3 caractéries', 
                            'stringLengthTooLong' => 'Máximo aceito: 50 caractéries', 
                        ),
                    ),
                ),                
            )
        ));        
    }
    
    private function setUserFilterNumero(){
        
        $this->add(array(
            'name'=>'numero',
            'required'=>false,
            'filters' => array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'max' => 10,
                        'messages' => array(
                            'stringLengthTooLong' => 'Máximo aceito: 10 caractéries', 
                        ),
                    ),
                ),                
            )
        ));              
    }
    
    private function setUserFilterComplemento(){
        
        $this->add(array(
            'name'=>'complemento',
            'required'=>false,
            'filters' => array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'max' => 100,
                        'messages' => array(
                            'stringLengthTooLong' => 'Máximo aceito: 100 caractéries', 
                        ),
                    ),
                ),                
            )
        ));              
    }
    
    private function setUserFilterBairro(){
        
        $this->add(array(
            'name'=>'bairro',
            'required'=>true,
            'filters' => array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'=>'NotEmpty',
                    'options'=>array(
                        'messages'=>array('isEmpty'=>'Não pode estar em branco')
                    )
                ),
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 60,
                        'messages' => array(
                            'stringLengthTooShort' => 'Mínimo aceito: 3 caractéries', 
                            'stringLengthTooLong' => 'Máximo aceito: 60 caractéries', 
                        ),
                    ),
                ),                
            )
        ));        
    }   
    
    private function setUserFilterCidade(){
        
        $this->add(array(
            'name'=>'cidade',
            'required'=>true,
            'filters' => array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'=>'NotEmpty',
                    'options'=>array(
                        'messages'=>array('isEmpty'=>'Não pode estar em branco')
                    )
                ),
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 60,
                        'messages' => array(
                            'stringLengthTooShort' => 'Mínimo aceito: 3 caractéries', 
                            'stringLengthTooLong' => 'Máximo aceito: 60 caractéries', 
                        ),
                    ),
                ),                
            )
        ));        
    }   
    
    private function setUserFilterEstado(){
        
        $this->add(array(
            'name'=>'estado',
            'required'=>true,
            'filters' => array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'=>'NotEmpty',
                    'options'=>array(
                        'messages'=>array('isEmpty'=>'Não pode estar em branco')
                    )
                ),
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 2,
                        'max' => 2,
                        'messages' => array(
                            'stringLengthTooShort' => 'Mínimo aceito: 2 caractéries', 
                            'stringLengthTooLong' => 'Máximo aceito: 2 caractéries', 
                        ),
                    ),
                ),                
            )
        ));        
    }   
    
    private function setUserFilterCep(){
        
        $this->add(array(
            'name'=>'cep',
            'required'=>true,
            'filters' => array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'=>'NotEmpty',
                    'options'=>array(
                        'messages'=>array('isEmpty'=>'Não pode estar em branco')
                    )
                ),
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 8,
                        'max' => 10,
                        'messages' => array(
                            'stringLengthTooShort' => 'Mínimo aceito: 8 caractéries', 
                            'stringLengthTooLong' => 'Máximo aceito: 10 caractéries', 
                        ),
                    ),
                ),                
            )
        ));        
    }   

}
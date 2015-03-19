<?php

namespace AGUser\Filter;

use Zend\InputFilter\InputFilter;

class NewPassWordFilter extends InputFilter {

    public function __construct() {

        $this->setUserFilterPassword();
        $this->setUserFilterConfirmation();
    }
    
    private function setUserFilterPassword(){
        
        $this->add(array(
           'name'=>'password',
            'required'=>true,
            'filters' => array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name'=>'NotEmpty',
                    'options'=>array(
                        'messages'=>array(
                            'isEmpty'=>'Não pode estar em branco'
                        )
                    )
                )
            )
        ));
    }
    
    private function setUserFilterConfirmation(){
       
        $this->add(array(
           'name'=>'confirmation',
            'required'=>true,
            'filters' => array(
                array('name'=>'StripTags'),
                array('name'=>'StringTrim'),
            ),
           'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            'isEmpty' => "Este campo deve ser preenchido."
                        )
                    ),
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'password',
                        'messages' => array(
                            'notSame' => "As senhas não coincidem."
                        )                        
                    )
                )
            )            
        ));        
    }

}
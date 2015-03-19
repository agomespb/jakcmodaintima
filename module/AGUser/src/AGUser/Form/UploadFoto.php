<?php

namespace AGUser\Form;

use Zend\Form\Form,
    Zend\Form\Element\File;

use AGUser\Filter\UploadFotoFilter;

class UploadFoto  extends Form
{
    public function __construct() {
        
        parent::__construct('upload');
        
        $this->setAttribute('role', 'form');        
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-signin');
        
        $this->setInputFilter(new UploadFotoFilter());
        
        $foto = new File('foto');
        $foto->setAttribute('required', true)
             ->setAttribute('class', "input-text");        
        $this->add($foto);
        
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

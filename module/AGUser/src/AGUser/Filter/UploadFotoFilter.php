<?php

namespace AGUser\Filter;

use Zend\InputFilter\InputFilter,
    Zend\InputFilter\FileInput,
    Zend\Filter\File\RenameUpload,
    Zend\Validator\File\Size,
    Zend\Validator\File\MimeType;

class UploadFotoFilter extends InputFilter {

    public function __construct() {

        $foto = new FileInput('foto');
        $foto->setRequired(true);
        
        $foto->getFilterChain()->attach(new RenameUpload(array(
            'target' => './public/img/users/ag',
            'use_upload_extension' => true,
            'randomize' => true,
        )));
    
        $foto->getValidatorChain()->attach(new Size(array(
            'max' => substr(ini_get('upload_max_filesize'), 0, -1).'MB'
        )));
    
        $foto->getValidatorChain()->attach(new MimeType(array(
            'image/gif',
            'image/jpeg',
            'image/png',
            'enableHeaderCheck' => true
        )));
        
        $this->add($foto);
    }
}
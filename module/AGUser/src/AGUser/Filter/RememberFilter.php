<?php

namespace AGUser\Filter;

use Zend\InputFilter\InputFilter;

class RememberFilter extends InputFilter {

    public function __construct() {

        $this->setUserFilterEmail();
    }
    
    private function setUserFilterEmail(){
        
        $validator = new \Zend\Validator\EmailAddress();
        $validator->setOptions(array('domain'=>FALSE));
        
//        $validator->setMessages(
//            array(
//                'emailAddressInvalid' => "Tipo de dado inválido.",
//                'emailAddressInvalidFormat' => "A entrada não é um endereço de email válido.",
//                'emailAddressInvalidHostname' => "'%hostname%' não é um nome de host válido para o endereço de e-mail.",
//                'emailAddressInvalidMxRecord' => "'%hostname%' não parece ter qualquer registro MX ou A válidos para o endereço de email.",
//                'emailAddressInvalidSegment' => "'%hostname%' não é um segmento de rede em encaminháveis. O endereço de e-mail não deve ser resolvido a partir da rede pública.",
//                'emailAddressDotAtom' => "'%localpart%' não pode ser comparado com formato dot-átomo.",
//                'hostnameInvalidHostname' => "A entrada não coincide com a estrutura esperada para um nome DNS.",
//                'hostnameLocalNameNotAllowed' => "A entrada parece ser um nome de rede local, mas nomes de redes locais não são permitidos.",
//                'emailAddressLengthExceeded' => "A entrada não parece ser um nome de rede local válido.",
//                'hostnameInvalidLocalName' => "O valor de entrada não parece ser um nome de rede local válido.",
//                'hostnameInvalidHostnameSchema' => "O valor de entrada parece ser um hostname de DNS, mas não corresponde ao esquema de hostname para o TLD '%tld%'",
//            )
//        );  
        
        $this->add(array(
            'name' => 'email',
            'validators' => array($validator,
                array('name'=>'NotEmpty','options'=>array('messages'=>array('isEmpty'=>'Não pode estar em branco'))))
            )
        );        
    }
}
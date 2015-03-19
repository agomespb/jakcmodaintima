<?php

namespace AGUser\Service;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Math\Rand;

use AGBase\Mail\Mail;

class Remember extends AbstractService
{
    protected $transport;
    protected $view;
    
    public function __construct(EntityManager $em, SmtpTransport $transport, $view) 
    {
        parent::__construct($em);
        
        $this->entity = "AGUser\Entity\User";
        $this->transport = $transport;
        $this->view = $view;
    }
    
    public function rememberme(array $data) {

        $server = $_SERVER['SERVER_NAME'];
        
        $dataEmail = array('nome'=>$data['nome'],'remember'=>$data['salt'], 'server'=>$server);

        $mail = new Mail($this->transport, $this->view, 'remember');
        $mail->setSubject('Confirmar solicitação de senha.')
                ->setTo($data['email'])
                ->setData($dataEmail)
                ->prepare()
                ->send();
        
        return $mail;
    }
    
    public function update(array $data)
    {
        $data['salt'] = md5(Rand::getBytes(8, true));
        
        $entity = $this->em->getReference($this->entity, $data['id']);
        
        (new Hydrator\ClassMethods())->hydrate($data, $entity);
        
        $this->em->persist($entity);
        $this->em->flush();
        
        return $entity;
    }
    
}

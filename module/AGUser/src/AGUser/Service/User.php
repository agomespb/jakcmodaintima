<?php

namespace AGUser\Service;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;
use Zend\Mail\Transport\Smtp as SmtpTransport;

use AGBase\Mail\Mail;

class User extends AbstractService
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
    
    public function insert(array $data) {

        $entity = parent::insert($data);
        
        if($entity)
        {
            $dataEmail = array('nome'=>$data['nome'],'activationKey'=>$entity->getActivationKey());
            
            $mail = new Mail($this->transport, $this->view, 'add-user');
            $mail->setSubject('Confirmação de cadastro')
                    ->setTo($data['email'])
                    ->setData($dataEmail)
                    ->prepare()
                    ->send();
        }
        
        return $entity;
    }
    
    public function activate($key)
    {
        $repo = $this->em->getRepository("AGUser\Entity\User");
        
        $user = $repo->findOneByActivationKey($key);
        
        if($user && !$user->getActive())
        {
            $user->setActive(true);
            $this->em->persist($user);
            $this->em->flush();
            
            return $user;
        }
    }
    
    public function update(array $data)
    {
        if(empty($data['password'])){
            unset($data['password']);
        }
        
        $role = $this->em->getReference("AGAcl\Entity\Role",$data['role']);
        $entity = $this->em->getReference($this->entity, $data['id']);

        (new Hydrator\ClassMethods())->hydrate($data, $entity);
        
        $entity->setRole($role); // Injetando entidade carregada         
        
        $this->em->persist($entity);
        $this->em->flush();
        
        return $entity;
    }
    
}

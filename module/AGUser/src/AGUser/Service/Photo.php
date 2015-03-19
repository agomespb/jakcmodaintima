<?php

namespace AGUser\Service;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;

class Photo extends AbstractService
{
    
    public function __construct(EntityManager $em) 
    {
        parent::__construct($em);
        $this->entity = "AGUser\Entity\Photo";
    }
    
    public function save(array $data){
        
        $repo = $this->em->getRepository($this->entity);
        $photo = $repo->findOneByUser($data['user']); 
        
        if($photo){
            
            $filename = "./public/img/users/".$photo->getFoto();

            if(file_exists($filename)){
                unlink($filename);
            }
            
            $data['id'] = $photo->getId();
            $this->update($data);
            
        } else {
            $this->insert($data);
        }        
        
        return $this;
    }

    public function insert(array $data) {

        $entity = new $this->entity($data);

        $user = $this->em->getReference("AGUser\Entity\User",$data['user']);
        $entity->setUser($user); // Injetando entidade carregada
        
        $this->em->persist($entity);
        $this->em->flush();
        
        return $entity;        

    }
    
    public function update(array $data)
    {
        $user = $this->em->getReference("AGUser\Entity\User",$data['user']);
        $entity = $this->em->getReference($this->entity, $data['id']);

        (new Hydrator\ClassMethods())->hydrate($data, $entity);
        
        $entity->setUser($user); // Injetando entidade carregada         
        
        $this->em->persist($entity);
        $this->em->flush();
        
        return $entity;
    }
    
}

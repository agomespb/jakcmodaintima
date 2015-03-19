<?php

namespace AGAcl\Service;

use AGBase\Service\AbstractService;
use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;

class Privilege extends AbstractService
{
    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = "AGAcl\Entity\Privilege";
    }
    
    public function insert(array $data)
    {
        $entity = new $this->entity($data);
        
        $role = $this->em->getReference("AGAcl\Entity\Role",$data['role']);
        $entity->setRole($role); // Injetando entidade carregada
        
        $resource = $this->em->getReference("AGAcl\Entity\Resource",$data['resource']);
        $entity->setResource($resource); // Injetando entidade carregada
        
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }
    
    public function update(array $data)
    {
        $entity = $this->em->getReference($this->entity, $data['id']);
        (new Hydrator\ClassMethods())->hydrate($data, $entity);
        
        $role = $this->em->getReference("AGAcl\Entity\Role",$data['role']);
        $entity->setRole($role); // Injetando entidade carregada
        
        $resource = $this->em->getReference("AGAcl\Entity\Resource",$data['resource']);
        $entity->setResource($resource); // Injetando entidade carregada
        
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }
    
}

<?php

namespace AGUser\Service;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator;
use Zend\Mvc\Controller\AbstractActionController; // Necessário para usar o flashMessenger!

abstract class AbstractService extends AbstractActionController
{
    /**
     *
     * @var EntityManager
     */
    protected $em;
    protected $entity;
    
    public function __construct(EntityManager $em) 
    {
        $this->em = $em;
    }
    
    public function insert(array $data)
    {
        $entity = new $this->entity($data);
        
        $role = $this->em->getReference("AGAcl\Entity\Role",$data['role']);
        $entity->setRole($role); // Injetando entidade carregada
        
        try {
            $this->em->persist($entity);
            $this->em->flush();
            return $entity;
        } catch (\Doctrine\DBAL\DBALException $e) {
            $msg = $e->getMessage();
            
            $errorSQLSTATE23000 = strpos($msg, 'SQLSTATE[23000]');

            if ($errorSQLSTATE23000) {
                $messager = "<h3>Duplicidade de E-mail</h3><h4>Você deve informar outro e-mail.</h4>";
                $this->flashMessenger()->addErrorMessage($messager);
            } else {
                $messager = "<h3>Ops!!!</h3><h4>Ocorreu um erro desconhecido.</h4>";
                $this->flashMessenger()->addErrorMessage($messager);
            }            
            return FALSE;
        }
    }
    
    public function update(array $data)
    {
        $entity = $this->em->getReference($this->entity, $data['id']);
        
        (new Hydrator\ClassMethods())->hydrate($data, $entity);
        
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }
    
    public function delete($id)
    {
        $entity = $this->em->getReference($this->entity, $id);
        if($entity)
        {
            $this->em->remove($entity);
            $this->em->flush();
            return $id;
        }
    }
    
}

<?php

namespace AGUser\Repository;

use Doctrine\ORM\EntityRepository;

class StatesRepository extends EntityRepository 
{
    public function fetchParent()
    {
        $entities = $this->findAll();
        
        $array = array();
        foreach($entities as $entity)
        {
            $array[$entity->getSigla()]=$entity->getNome();
        }
        
        return $array;
    }    
}

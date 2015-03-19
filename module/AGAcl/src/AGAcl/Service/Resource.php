<?php

namespace AGAcl\Service;

use AGBase\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class Resource extends AbstractService
{
    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = "AGAcl\Entity\Resource";
    }
    
    
}

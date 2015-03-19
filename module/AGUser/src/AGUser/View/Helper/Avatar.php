<?php

namespace AGUser\View\Helper;

use Zend\View\Helper\AbstractHelper,
    Doctrine\ORM\EntityManager;

class Avatar extends AbstractHelper {
    
    protected $em;
    protected $entity;
    
    public function __construct(EntityManager $em) 
    {
        $this->em = $em;
        $this->entity = "AGUser\Entity\Photo";
    }
    
    public function __invoke($idu = null)
    {
        $repo = $this->em->getRepository($this->entity);
        $photo = $repo->findOneByUser($idu); 
        
        if($photo){
            return "img/users/".$photo->getFoto();
        } else {
            return "img/photo.png";
        }
    }    
    
}

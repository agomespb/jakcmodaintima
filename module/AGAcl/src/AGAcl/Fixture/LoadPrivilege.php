<?php

namespace AGAcl\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use AGAcl\Entity\Privilege;

class LoadPrivilege extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        
        $role1 = $manager->getReference('AGAcl\Entity\Role',1);
        $resource1 = $manager->getReference('AGAcl\Entity\Resource',3);
        
        $role2 = $manager->getReference('AGAcl\Entity\Role',2);
        $resource2 = $manager->getReference('AGAcl\Entity\Resource',3);
        
        $role3 = $manager->getReference('AGAcl\Entity\Role',3);
        $resource3 = $manager->getReference('AGAcl\Entity\Resource',3);
        
        $role4 = $manager->getReference('AGAcl\Entity\Role',4);
        $resource4 = $manager->getReference('AGAcl\Entity\Resource',3);
        
        $privilege1 = new Privilege;
        $privilege1->setNome("index")
                ->setRole($role1)
                ->setResource($resource1);        
        $manager->persist($privilege1);
        
        $privilege2 = new Privilege;
        $privilege2->setNome("edit")
                ->setRole($role2)
                ->setResource($resource2);        
        $manager->persist($privilege2);
        
        $privilege3 = new Privilege;
        $privilege3->setNome("new")
                ->setRole($role3)
                ->setResource($resource3);        
        $manager->persist($privilege3);
        
        $privilege4 = new Privilege;
        $privilege4->setNome("delete")
                ->setRole($role4)
                ->setResource($resource4);        
        $manager->persist($privilege4);
        
        $manager->flush();  
        
    }

    public function getOrder() {
        return 3;
    }
}

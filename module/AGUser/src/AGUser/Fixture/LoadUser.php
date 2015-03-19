<?php

namespace AGUser\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use AGUser\Entity\User;

// Para executar essa classe: vendor/bin/doctrine-module data-fixture:import

class LoadUser extends AbstractFixture implements OrderedFixtureInterface
{
    
    public function load(ObjectManager $manager) {
        
        $role1 = $manager->getReference('AGAcl\Entity\Role',1);
        $role4 = $manager->getReference('AGAcl\Entity\Role',4);
        
        $user = new User();
        $user->setNome("Alexandre Gomes")
                ->setRole($role4)
                ->setEmail("agomespb@gmail.com")
                ->setPassword(123456)
                ->setActive(true);
        
        $manager->persist($user);
        
        $user = new User();
        $user->setNome("José Maria")
                ->setRole($role1)
                ->setEmail("agomes@facex.edu.br")
                ->setPassword(123456)
                ->setActive(true);
        
        $manager->persist($user);
        
        $manager->flush();
        
    }

    public function getOrder() {
        return 4;
    }
}

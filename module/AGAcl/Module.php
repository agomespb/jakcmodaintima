<?php

namespace AGAcl;

class Module
{
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            /**
             * Aumento de Performance com autoload_classmap.php!
             * 
             * Dentro do Módulo execute:
             * ~> php ../../vendor/zendframework/zendframework/bin/classmap_generator.php 
             */
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'AGAcl\Form\Role' => function($sm)
                {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $repo = $em->getRepository('AGAcl\Entity\Role');
                    $parent = $repo->fetchParent();

                    return new Form\Role('role',$parent);
                },
                'AGAcl\Form\Privilege' => function($sm)
                {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $repoRoles = $em->getRepository('AGAcl\Entity\Role');
                    $roles = $repoRoles->fetchParent();

                    $repoResources = $em->getRepository('AGAcl\Entity\Resource');
                    $resources = $repoResources->fetchPairs();

                    return new Form\Privilege("privilege", $roles, $resources);
                },
                'AGAcl\Service\Role' => function($sm){
                    return new Service\Role($sm->get('Doctrine\ORM\Entitymanager'));
                },
                'AGAcl\Service\Resource' => function($sm){
                    return new Service\Resource($sm->get('Doctrine\ORM\Entitymanager'));
                },
                'AGAcl\Service\Privilege' => function($sm){
                    return new Service\Privilege($sm->get('Doctrine\ORM\Entitymanager'));
                },

                'AGAcl\Permissions\Acl' => function($sm)
                {
                    $em = $sm->get('Doctrine\ORM\EntityManager');

                    $repoRole = $em->getRepository("AGAcl\Entity\Role");
                    $roles = $repoRole->findAll();

                    $repoResource = $em->getRepository("AGAcl\Entity\Resource");
                    $resources = $repoResource->findAll();

                    $repoPrivilege = $em->getRepository("AGAcl\Entity\Privilege");
                    $privileges = $repoPrivilege->findAll();

                    return new Permissions\Acl($roles,$resources,$privileges);
                }
            )  
        );
    }
}

<?php

namespace AGBase;

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
        );
    }    
}

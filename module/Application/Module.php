<?php

namespace Application;

use Zend\Validator\AbstractValidator;
use Zend\Mvc\I18n\Translator;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        ini_set('date.timezone', 'America/Recife');
        
        //Esse é o código para a tradução

        //Pega o serviço translator definido no arquivo module.config.php (aliases)
        $translator = $e->getApplication()->getServiceManager()->get( 'translator' );

        //Define o local onde se encontra o arquivo de tradução de mensagens
        $translator->addTranslationFile ( 'phpArray', './vendor/zendframework/zendframework/resources/languages/pt_BR/Zend_Validate.php' );

        //Define o local (você também pode definir diretamente no método acima
        $translator->setLocale ( 'pt_BR' );
        
        //Define a tradução padrão do Validator
        AbstractValidator::setDefaultTranslator ( new Translator ( $translator ) );         
    }

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
            // 'Zend\Loader\StandardAutoloader' => array(
            //   'namespaces' => array(
            //       __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
            //    ),
            // ),
        );
    }
}

<?php

namespace AGUser;

use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage,
    Zend\ModuleManager\ModuleManager,
    Zend\Mvc\MvcEvent;

use AGUser\Auth\Adapter as AuthAdapter;
use AGUser\View\Helper\HelperMenu as MenuHelper;
use AGUser\View\Helper\Message as MessageHelper;

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
//             'Zend\Loader\StandardAutoloader' => array(
//               'namespaces' => array(
//                   __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
//                ),
//             ),
        );
    }
    
    public function init(ModuleManager $moduleManager)
    {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        
        $sharedEvents->attach(
                "Zend\Mvc\Controller\AbstractActionController", 
                MvcEvent::EVENT_DISPATCH,
                array($this,'validaAuth'),100);
    }
    
    public function validaAuth($e)
    {
        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage("AGUser"));
        
        $controller = $e->getTarget();
        $matchedRoute = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();
        
        $admRoutes = array(
            "agacl-admin", 
            "agacl-admin/paginator", 
            "aguser-admin",
            "aguser-admin/paginator",
        );

        if(!$auth->hasIdentity() and (in_array($matchedRoute, $admRoutes))){
            return $controller->redirect()->toRoute("aguser-auth");
        }    
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'AGUser\Mail\Transport' => function($sm) {

                  $config = $sm->get('Config'); // Pega as configs do Global - mail

                  $transport = new SmtpTransport;
                  $options = new SmtpOptions($config['mail']);
                  $transport->setOptions($options);

                  return $transport;
                },
                'AGUser\Service\User' => function($sm) {
                    return new Service\User($sm->get('Doctrine\ORM\EntityManager'),
                                            $sm->get('AGUser\Mail\Transport'),
                                            $sm->get('View'));
                },
                'AGUser\Service\Remember' => function($sm) {
                    return new Service\Remember($sm->get('Doctrine\ORM\EntityManager'),
                                            $sm->get('AGUser\Mail\Transport'),
                                            $sm->get('View'));
                },
                'AGUser\Service\Photo' => function($sm) {
                    return new Service\Photo($sm->get('Doctrine\ORM\EntityManager'));
                },
                'AGUser\Service\Address' => function($sm) {
                    return new Service\Address($sm->get('Doctrine\ORM\EntityManager'));
                },
                'AGUser\Auth\Adapter' => function($sm)
                {
                    return new AuthAdapter($sm->get('Doctrine\ORM\EntityManager'));
                },
                'AGUser\Form\User' => function($sm)
                {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $repoRoles = $em->getRepository('AGAcl\Entity\Role');
                    $roles = $repoRoles->fetchParent();

                    return new Form\User($name = null, $options = array(), $roles);
                },               
                'AGUser\Form\Address' => function($sm)
                {
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $repoEstados = $em->getRepository('AGUser\Entity\States');
                    $estados = $repoEstados->fetchParent();

                    return new Form\Address($options = array(), $estados);
                },               
            )  
        );
    }
    
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'MenuHelperActive' => function($service) {
                    return new MenuHelper($service->getServiceLocator()->get('Request'));
                },
                'message' => function($sm) {
                    return new MessageHelper($sm->getServiceLocator()->get('ControllerPluginManager')->get('flashmessenger'));
                },
                'UserIdentity' => function() {
                    return new View\Helper\UserIdentity();
                },
                'Avataar' => function($sm) {
                    return new View\Helper\Avatar($sm->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
                },
                'RouterHelper' => function($sm) {
                    return new View\Helper\RouterHelper($sm->getServiceLocator()->get('application')->getMvcEvent()->getRouteMatch());
                },
            ),            
        );
    }   
    
}


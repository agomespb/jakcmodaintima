<?php

namespace AGProduct\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

use Zend\Paginator\Paginator,
    Zend\Paginator\Adapter\ArrayAdapter;

use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;

abstract class CrudController extends AbstractActionController
{
    protected $em;
    protected $service;
    protected $entity;
    protected $form;
    protected $route;
    protected $controller;
    protected $authService; 
    
    public function indexAction() {
        
        if(!$this->authorization('index')){
            return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));           
        }        
        
        $list = $this->getEm()->getRepository($this->entity)->findAll();
        
        $page = $this->params()->fromRoute('page');
        
        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page)->setDefaultItemCountPerPage(5);
        
        return new ViewModel(array('data'=>$paginator,'page'=>$page, 'controller' => $this->controller));
    }

    public function newAction()
    {
        if(!$this->authorization('new')){
            return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
        }
        
        $form = new $this->form();
        $request = $this->getRequest();
        
        if($request->isPost())
        {
            $form->setData($request->getPost());
            if($form->isValid())
            {
                $service = $this->getServiceLocator()->get($this->service);
                $service->insert($request->getPost()->toArray());

                return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
            }
        }
        
        return new ViewModel(array('form'=>$form));
    }
    
    public function editAction()
    {
        if(!$this->authorization('edit')){
            return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
        }        
        
        $form = new $this->form();
        $request = $this->getRequest();
        
        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->find($this->params()->fromRoute('id',0));
        
        if($this->params()->fromRoute('id',0)){
            $form->setData($entity->toArray());
        }
        
        if($request->isPost())
        {
            $form->setData($request->getPost());
            if($form->isValid())
            {
                $service = $this->getServiceLocator()->get($this->service);
                $service->update($request->getPost()->toArray());
                
                return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
            }
        }
        
        return new ViewModel(array('form'=>$form));
    }
    
    public function deleteAction()
    {
        if(!$this->authorization('delete')){
            return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
        }
        
        $service = $this->getServiceLocator()->get($this->service);
        if($service->delete($this->params()->fromRoute('id',0))){
            return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
        }
    }
    
    /**
     * 
     * @return EntityManager
     */
    protected function getEm()
    {
        if(null === $this->em){
            $this->em = $this->getServiceLocator()->get ('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }
    
    protected function authorization($action){
        
        // 1.) Dados do Usuário Logado
        $identity = $this->IdentityUser("AGUser");
        if(!$identity){
            return $this->redirect()->toRoute("aguser-auth");   
        }
        
        // 2.) Localiza seu papel através do ID
        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->find($identity->getId()); 

        // 3.) Cosulta suas permissões
        $acl  = $this->getServiceLocator()->get("AGAcl\Permissions\Acl");
        $perm = ($acl->isAllowed($entity->getRole()->getNome(),  $this->controller, $action))? TRUE : FALSE;
        
        if(!$perm){
            $messager = "<h3>Acesso Negado</h3><h4>Você não possui permissão.</h4>";
            $this->flashMessenger()->addErrorMessage($messager);
        }
        
        return $perm;
    }

    public function getAuthService() {
        return $this->authService;
    }

    public function IdentityUser($namespace = null) {
  
        $sessionStorage = new SessionStorage($namespace);
        $this->authService = new AuthenticationService;
        $this->authService->setStorage($sessionStorage);

        if ($this->getAuthService()->hasIdentity()) {
            return $this->getAuthService()->getIdentity();
        } else {
            return false;
        }
    }    
}

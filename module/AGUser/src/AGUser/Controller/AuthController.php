<?php

namespace AGUser\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;

use AGUser\Form\Login as LoginForm;

class AuthController extends AbstractActionController
{
    protected $em;
    protected $entity;
    protected $form;
    protected $controller;
    protected $route;
    
    public function __construct() 
    {
        $this->entity = "AGUser\Entity\User";
        $this->form = "AGUser\Form\NewPassWord";
        $this->service = "AGUser\Service\Remember";
        $this->controller = "Auth";
        $this->route = "aguser-auth";
    }    

    public function indexAction()
    {
        $return  = false;
        $error   = false;
        $form    = new LoginForm;
        $request = $this->getRequest();
        
        if($request->isPost())
        {
            $form->setData($request->getPost());
            
            if($form->isValid()) {
                $data = $request->getPost()->toArray();
                $return = $this->authentication($data);
            }
            
            if($return){
                return $this->redirect()->toRoute('aguser-admin/default',array('controller'=>'users', 'action' => 'index'));
            } else {
                $error = true;
            }
        }

        
//        $view = new ViewModel(array('form'=>$form,'error'=>$error));
//        $view->setTerminal(true); // desabilita a renderização do layout
//        return $view;        
        
        return new ViewModel(array('form'=>$form,'error'=>$error));
    }
    
    private function authentication(array $data){
        
        $return = false;
        
        // Criando Storage para gravar sessão da autenticação
        $sessionStorage = new SessionStorage("AGUser");

        $auth = new AuthenticationService;
        $auth->setStorage($sessionStorage); // Definindo o SessionStorage para a auth

        $authAdapter = $this->getServiceLocator()->get("AGUser\Auth\Adapter");
        $authAdapter->setUsername($data['email']);
        $authAdapter->setPassword($data['password']);

        $result = $auth->authenticate($authAdapter);

        if($result->isValid())
        {
            // $user = $auth->getIdentity();
            // $user = $user['user'];
            // $sessionStorage->write($user,null);
            $sessionStorage->write($auth->getIdentity()['user'],null);
            $this->flashMessenger()->addSuccessMessage("Acesso concebido com sucesso!");
            $return = true;
        }
        
        return $return;
    }

    public function logoutAction()
    {
        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage("AGUser"));
        $auth->clearIdentity();
        
        $this->flashMessenger()->addInfoMessage("Você foi desconectado com sucesso!");
        return $this->redirect()->toRoute('aguser-auth');
    }
    
    public function ajudaAction()
    {
        $return  = false;
        $form    = new \AGUser\Form\Remember();
        $request = $this->getRequest();
        
        if($request->isPost())
        {
            $sended = false;
            $form->setData($request->getPost());
            
            if($form->isValid())
            {
                $data = $form->getData();
                $sended = $this->sendMailRemember($data);
            } else {
                // \Zend\Debug\Debug::dump($form->getMessages());
            }
            
            if($sended){
                return $this->redirect()->toRoute('aguser-auth');
            } else {
                $return = "O email informado não consta em nossa base de dados.";
            }            
        }
        return new ViewModel(array('form'=>$form,'error'=>$return));
    }
    
    private function sendMailRemember(array $data){
        
        $return = false;
        
        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->findOneByEmail($data['email']);  

        if($entity){
            // Envia o E-mail
            $data = $entity->toArray();
            $service = $this->getServiceLocator()->get("AGUser\Service\Remember");

            if($service->rememberme($data)) 
            {
                $messager = "<h4>E-mail enviado com sucesso!</h4><h5>Confira seu e-mail. Enviamos um link para atualizar sua senha.</h5>";
                $this->flashMessenger()->addSuccessMessage($messager);  
                $return = true;
            }
        } 
        return $return;
    }

    public function newPassWordAction()
    {
        $form = new $this->form;
        $request = $this->getRequest();
        
        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->findOneBySalt($this->params()->fromRoute('remember', 0));
        
        if($entity) {
            $array = $entity->toArray();
            unset($array['password']);
            $form->setData($array);
        }
        
        if($request->isPost()) {
            
            $data = $request->getPost()->toArray();
            
            if($this->savePassWord($data, $form)){
                return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
            }
        }
        
        return new ViewModel(array('form'=>$form));
    }   
    
    private function savePassWord(array $data, $form){
        
        $return = false;
        
        if(!$data['id']){
            return $return;
        }
            
        $form->setData($data);
        if($form->isValid()) {
            $service = $this->getServiceLocator()->get($this->service);
            $service->update($data);
            $return = true;
        }
        
        return $return;
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
}

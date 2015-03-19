<?php

namespace AGUser\Controller;

use Zend\View\Model\ViewModel;

class UsersController extends CrudController 
{

    public function __construct() 
    {
        $this->entity = "AGUser\Entity\User";
        $this->form = "AGUser\Form\User";
        $this->service = "AGUser\Service\User";
        $this->controller = "users";
        $this->route = "aguser-admin";
        
//         \Zend\Debug\Debug::dump($this->controller); die;
    }

    public function newAction()
    {
        if(!$this->authorization('new')){
            return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
        }
        
        $form = $this->getServiceLocator()->get($this->form);
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
        
        $form = $this->getServiceLocator()->get($this->form);
        $request = $this->getRequest();
        
        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->find($this->params()->fromRoute('id',0));
        
        if($this->params()->fromRoute('id',0))
        {
            $array = $entity->toArray();
            unset($array['password']);
            $form->setData($array);
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

    public function addressAction()
    {
        // Dados do Usuário Logado
        $identity = $this->IdentityUser("AGUser");
        if(!$identity){
            return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
        }

        $this->entity = "AGUser\Entity\Address";
        $this->form = "AGUser\Form\Address";
        $this->service = "AGUser\Service\Address";        
        $address = array();
        
        $repo = $this->getEm()->getRepository($this->entity);
        $repoAddress = $repo->findOneByUser($identity->getId()); 
        
        $form = $this->getServiceLocator()->get($this->form);
        
        if($repoAddress){
            $address = $repoAddress->toArray();
            $form->setData($address);
        } 
        
        $request = $this->getRequest();
        
        if($request->isPost())
        {
            $form->setData($request->getPost());
            if($form->isValid())
            {
                $data = $form->getData();
                $data['user'] = $identity->getId();
                $service = $this->getServiceLocator()->get($this->service);
                $service->save($data);
                
                $messager = "<h4>Endereço</h4><h5>Salvo com sucesso.</h5>";
                $this->flashMessenger()->addSuccessMessage($messager);                

                return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
            }
        }
        
        return new ViewModel(array('form'=>$form, 'address'=>$address));
    }    
}

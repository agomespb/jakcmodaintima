<?php

namespace AGAcl\Controller;

use AGBase\Controller\CrudController;
use Zend\View\Model\ViewModel;

class RolesController extends CrudController
{

    public function __construct() {
        $this->entity = "AGAcl\Entity\Role";
        $this->service = "AGAcl\Service\Role";
        $this->form = "AGAcl\Form\Role";
        $this->controller = "roles";
        $this->route = "agacl-admin-roles";
    }
    
    public function newAction()
    {
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
        $form = $this->getServiceLocator()->get('AGAcl\Form\Role');
        $request = $this->getRequest();
        
        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->find($this->params()->fromRoute('id',0));
        
        if($this->params()->fromRoute('id',0))
            $form->setData($entity->toArray());
        
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
    
    public function testeAction()
    {
        $acl = $this->getServiceLocator()->get("AGAcl\Permissions\Acl");
        
        echo $acl->isAllowed("Redator","Posts","Visualizar")? "Permitido" : "Negado";
        die;
    }
}

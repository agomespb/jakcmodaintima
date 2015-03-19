<?php

namespace AGUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function registerAction()
    {
        $request = $this->getRequest();
        $form    = $this->getServiceLocator()->get("AGUser\Form\User");
        
        if($request->isPost())
        {
            $form->setData($request->getPost());
            
            if($form->isValid())
            {
                $data = $request->getPost()->toArray();
                $service = $this->getServiceLocator()->get("AGUser\Service\User");
                
                if($service->insert($data)) 
                {
                    $messager = "<h3>Parabéns!!!</h3><h4>Você foi cadastrado com sucesso.</h4>";
                    $this->flashMessenger()->addSuccessMessage($messager);                    
                    return $this->redirect()->toRoute('aguser-auth');
                } 
            } 
        }
        
        return new ViewModel(array('form'=>$form));
    }
    
    public function activateAction()
    {
        $activationKey = $this->params()->fromRoute('key');
        
        $userService = $this->getServiceLocator()->get('AGUser\Service\User');
        $result = $userService->activate($activationKey);
        
        if($result){
            return new ViewModel(array('user'=>$result));
        } else {
            return new ViewModel();
        }
    }    
    
}

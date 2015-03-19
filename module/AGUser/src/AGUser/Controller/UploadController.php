<?php

namespace AGUser\Controller;

use Zend\View\Model\ViewModel;

class UploadController extends CrudController
{
    private $errors = FALSE;

    protected $mimeTypes = array(
            'image/gif',
            'image/jpeg',
            'image/png',
    );
    
    public function __construct() 
    {
        $this->form = "AGUser\Form\UploadFoto";
        $this->entity = "AGUser\Entity\Photo";
        $this->service = "AGUser\Service\Photo";
        $this->controller = "upload";
        $this->route = "aguser-admin";
    }    
    
    public function indexAction() {

        // Dados do Usuário Logado
        $identity = $this->IdentityUser("AGUser");
        if(!$identity){
            return $this->redirect()->toRoute("aguser-auth");   
        }             
        
        $form = new $this->form;
        
        if($this->getRequest()->isPost()){
         
            $postData = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            if(!in_array($postData['foto']['type'], $this->mimeTypes)){
                $this->errors = TRUE;
                return new ViewModel(array('form' => $form, 'error' => $this->errors));
            }
            
            $form->setData($postData);
            
            if($form->isValid()){
                
                $data = $form->getData(); // usar para iserir no BANCO

                $file = explode("/",$data['foto']['tmp_name']);

                $array = array(
                    'id' => null,
                    'user' => $identity->getId(),
                    'foto' => end($file)
                );
                
                $service = $this->getServiceLocator()->get($this->service);
                $service->save($array);
                
                $messager = "<h3>Sucesso</h3><h4>Upload executado com sucesso.</h4>";
                $this->flashMessenger()->addSuccessMessage($messager);
                
                return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
            }
        }
        
        return new ViewModel(array('form' => $form, 'error' => $this->errors));
    }
}

<?php

namespace AGProduct\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProductsController extends AbstractActionController
{
    
    public function indexAction()
    {
        $pageActual = $this->params()->fromRoute('page',0);
        $route = $this->url()->fromRoute();
                
        return new ViewModel(array('page'=>$pageActual, 'route'=>$route));
    }    
    
}

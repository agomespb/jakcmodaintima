<?php

namespace AGUser\View\Helper;

use Zend\View\Helper\AbstractHelper;

class RouterHelper extends AbstractHelper {
    
    protected $router;
    
    public function __construct($router)
    {
        $this->router = $router;
    }
    
    public function __invoke()
    {
        return $this->router;
    }    
    
}

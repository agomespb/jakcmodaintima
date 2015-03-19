<?php

namespace AGUser\View\Helper;

use Zend\View\Helper\AbstractHelper,
    Zend\Http\Request;

class HelperMenu extends AbstractHelper {
    
    protected $request;
    
    public function __construct(Request $request) 
    {
        $this->request = $request;
    }
    
    public function __invoke($url_menu = '')
    {
        return $this->request->getUri()->getPath() == $url_menu ? 'class="active"' : '';
    }    
    
}

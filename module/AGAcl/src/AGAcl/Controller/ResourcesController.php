<?php

namespace AGAcl\Controller;

use AGBase\Controller\CrudController;

class ResourcesController extends CrudController
{

    public function __construct() {
        $this->entity = "AGAcl\Entity\Resource";
        $this->service = "AGAcl\Service\Resource";
        $this->form = "AGAcl\Form\Resource";
        $this->controller = "resources";
        $this->route = "agacl-admin-resources/default";
    }
}

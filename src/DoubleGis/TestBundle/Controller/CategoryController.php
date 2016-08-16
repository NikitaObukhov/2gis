<?php

namespace DoubleGis\TestBundle\Controller;

use DoubleGis\TestBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends ResourceController
{

    public function getCategoriesAction(Request $request)
    {
        return $this->indexAction($request);
    }

    public function getCategoryAction(Request $request, $id)
    {
        return $this->showAction($request);
    }

    protected function getResourceClass()
    {
        return 'DoubleGis\TestBundle\Entity\Category';
    }
}
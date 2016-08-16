<?php

namespace DoubleGis\TestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

class BuildingController extends ResourceController
{
    public function getBuildingsAction(Request $request)
    {
        return $this->indexAction($request);
    }

    public function getBuildingAction(Request $request, $id)
    {
        return $this->showAction($request);
    }


    protected function getResourceClass()
    {
        return 'DoubleGis\TestBundle\Entity\Building';
    }
}
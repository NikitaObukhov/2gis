<?php

namespace DoubleGis\TestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;


class BuildingOrganizationsController extends ResourceController
{

    public function getOrganizationsAction(Request $request, $id)
    {
        return $this->associationAction($request, $id, 'building');
    }

    protected function getResourceClass()
    {
        return 'DoubleGis\TestBundle\Entity\Organization';
    }
}
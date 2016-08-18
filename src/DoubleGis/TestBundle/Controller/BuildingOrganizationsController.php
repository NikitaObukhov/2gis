<?php

namespace DoubleGis\TestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


class BuildingOrganizationsController extends ResourceController
{

    /**
     * Get list of organizations in building
     *
     * @ApiDoc(
     *  resource = true,
     *  requirements = {
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "description"="ID of a building"
     *      }
     *  },
     *  output = {
     *      "class" = "DoubleGis\TestBundle\Entity\Organization",
     *      "collection" = true,
     *      "collectionName" = "organizations",
     *  },
     *  statusCodes = {
     *    200 = "",
     *    404 = "When building with given ID does not exist"
     *  })
     */
    public function getOrganizationsAction(Request $request, $id)
    {
        return $this->associationAction($request, $id, 'building');
    }

    protected function getResourceClass()
    {
        return 'DoubleGis\TestBundle\Entity\Organization';
    }
}
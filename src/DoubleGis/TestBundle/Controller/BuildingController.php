<?php

namespace DoubleGis\TestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class BuildingController extends ResourceController
{

    /**
     * Get list of buildings
     *
     * @ApiDoc(
     *  resource = true,
     *  output = {
     *      "class" = "DoubleGis\TestBundle\Entity\Building",
     *      "collection" = true,
     *      "collectionName" = "buildings",
     *  })
     */
    public function getBuildingsAction(Request $request)
    {
        return $this->indexAction($request);
    }

    /**
     * Get a single building
     *
     * @ApiDoc(
     *  resource = true,
     *  output = {
     *      "class" = "DoubleGis\TestBundle\Entity\Building"
     *  },
     *  statusCodes = {
     *    200 = "",
     *    404 = "When building with given ID does not exist"
     *  })
     */
    public function getBuildingAction(Request $request, $id)
    {
        return $this->showAction($request);
    }


    protected function getResourceClass()
    {
        return 'DoubleGis\TestBundle\Entity\Building';
    }
}

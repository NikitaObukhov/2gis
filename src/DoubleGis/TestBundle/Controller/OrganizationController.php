<?php

namespace DoubleGis\TestBundle\Controller;

use DoubleGis\TestBundle\Controller\ResourceController;
use FOS\RestBundle\Request\ParamFetcher;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class OrganizationController extends ResourceController
{

    /**
     * Get list of organizations.
     *
     * @ApiDoc(
     *  resource = true,
     *  output = {
     *      "class" = "DoubleGis\TestBundle\Entity\Organization",
     *      "collection" = true,
     *      "collectionName" = "organizations",
     *  })
     * @QueryParam(name="name", requirements=".*", strict=true, description="Part of the name of organization to search for. Case does not matter.", nullable=true)
     * @QueryParam(name="category_id", requirements="\d+", strict=true, description="Search organizations in a category with given ID.", nullable=true)
     * @QueryParam(name="category_ancestor_id", requirements="\d+", strict=true, description="Search organizations which belong to given category or it's descendants.", nullable=true)
     * @Annotations\CircleParam(name="circle", nullable=true, description="Search organizations inside a given circle.", requirements="<radius (meters)>,<lat>,<lon>")
     * @Annotations\PolygonParam(name="polygon", nullable=true, mustBeClosed=true, description="Search organizations inside a given polygon. Please note that the first and last points must be the same.", requirements="<lat0>,<lon0>;<lat1><lon1>;...;<lat0><lon0>")
     */
    public function getOrganizationsAction(ParamFetcher $paramFetcher, Request $request)
    {
        $searchParams = $this->get('double_gis_test.organization_search_params');
        $resources = $this->getRepository()->findByParamsAndPaginate($searchParams);
        $view = $this->createViewFromPaginator($resources, $request);
        return $view;
    }

    /**
     * Display list of organizations on the map. This can be used to test if search params work well.
     *
     * @ApiDoc(
     *  resource = true)
     * @QueryParam(name="name", requirements=".*", strict=true, description="Part of the name of organization to search for. Case does not matter.", nullable=true)
     * @QueryParam(name="category_id", requirements="\d+", strict=true, description="Search organizations in a category with given ID.", nullable=true)
     * @QueryParam(name="category_ancestor_id", requirements="\d+", strict=true, description="Search organizations which belong to given category or it's descendants.", nullable=true)
     * @Annotations\CircleParam(name="circle", nullable=true, description="Search organizations inside a given circle.", requirements="<radius (meters)>,<lat>,<lon>")
     * @Annotations\PolygonParam(name="polygon", nullable=true, mustBeClosed=true, description="Search organizations inside a given polygon. Please note that the first and last points must be the same.", requirements="<lat0>,<lon0>;<lat1><lon1>;...;<lat0><lon0>")
     */
    public function getOrganizationsMapAction(ParamFetcher $paramFetcher)
    {
        $searchParams = $this->get('double_gis_test.organization_search_params');
        $resourses = $this->getRepository()->findByParams($searchParams);
        $response = new Response(null, 200, array('Content-Type' => 'text/html'));
        return $this->render('DoubleGisTestBundle::organizations_map.html.twig', array(
            'organizations' => $resourses,
            'circle' => $searchParams->getCircle(),
            'polygon' => $searchParams->getPolygon(),
        ), $response);
    }


    /**
     * Get a single organization
     *
     * @ApiDoc(
     *  resource = true,
     *  requirements = {
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "description"="Organization ID"
     *      }
     *  },
     *  output = {
     *      "class" = "DoubleGis\TestBundle\Entity\Organization"
     *  },
     *  statusCodes = {
     *    200 = "",
     *    404 = "When organization with a given ID does not exist"
     *  }
     * )
     */
    public function getOrganizationAction(Request $request, $id)
    {
        return $this->showAction($request);
    }



    protected function getResourceClass()
    {
        return 'DoubleGis\TestBundle\Entity\Organization';
    }
}
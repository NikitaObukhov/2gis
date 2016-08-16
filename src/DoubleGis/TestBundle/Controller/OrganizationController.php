<?php

namespace DoubleGis\TestBundle\Controller;

use DoubleGis\TestBundle\Controller\ResourceController;
use FOS\RestBundle\Request\ParamFetcher;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\Response;

class OrganizationController extends ResourceController
{

    /**
     * @QueryParam(name="name", requirements=".*", strict=true, description="", nullable=true)
     * @QueryParam(name="distance", requirements="\d+", strict=true, description="", nullable=true)
     * @QueryParam(name="latitude", requirements=".*", strict=true, description="", nullable=true)
     * @QueryParam(name="longitude", requirements=".*", strict=true, description="", nullable=true)
     * @QueryParam(name="category", requirements="\d+", strict=true, description="", nullable=true)
     */
    public function getOrganizationsAction(ParamFetcher $paramFetcher, Request $request)
    {
        $resources = $this->getRepository()->findByParams($paramFetcher);
        $view = $this->createViewFromPaginator(new Pagerfanta(new ArrayAdapter($resources)), $request);
        return $view;
    }

    /**
     * @Annotations\CircleParam(name="circle", nullable=true)
     * @Annotations\PolygonParam(name="polygon", nullable=true, mustBeClosed=true)
     * @QueryParam(name="name", requirements=".*", strict=true, description="", nullable=true)
     * @QueryParam(name="distance", requirements="\d+", strict=true, description="", nullable=true)
     * @QueryParam(name="latitude", requirements=".*", strict=true, description="", nullable=true)
     * @QueryParam(name="longitude", requirements=".*", strict=true, description="", nullable=true)
     * @QueryParam(name="category", requirements="\d+", strict=true, description="", nullable=true)
     */
    public function getOrganizationsMapAction(ParamFetcher $paramFetcher)
    {
        $resourses = $this->getRepository()->findByParams(
            $paramFetcher->get('name'),
            $circle = $paramFetcher->get('circle'),
            $polygon = $paramFetcher->get('polygon')
        );
        $response = new Response(null, 200, array('Content-Type' => 'text/html'));
        return $this->render('DoubleGisTestBundle::organizations_map.html.twig', array(
            'organizations' => $resourses,
            'circle' => $circle,
            'polygon' => $polygon,
        ), $response);
    }

    public function getOrganizationAction(Request $request, $id)
    {
        return $this->showAction($request);
    }



    protected function getResourceClass()
    {
        return 'DoubleGis\TestBundle\Entity\Organization';
    }
}
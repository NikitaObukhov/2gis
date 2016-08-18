<?php

namespace DoubleGis\TestBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Hateoas\Configuration\Route;
use Hateoas\Hateoas;
use Hateoas\HateoasBuilder;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;

abstract class ResourceController extends FOSRestController
{

    protected function indexAction(Request $request)
    {
        $repository = $this->getRepository();
        return $this->createViewFromPaginator($repository->createPaginator(), $request);
    }
    
    protected function associationAction(Request $request, $id, $associationField)
    {
        $repository = $this->getRepository();
        $resources = $repository->createAssociationPaginatorForParentEntity($id, $associationField);
        $resources->setCurrentPage($request->get('page', 1), true, true);
        $resources->setMaxPerPage($request->get('limit', 20));
        $resources = $this->getPagerfantaFactory()
            ->createRepresentation($resources, new Route(
                $request->attributes->get('_route'),
                $request->attributes->get('_route_params')
            ));

        $view = $this->view($resources);
        return $this->handleView($view);
    }

    protected function showAction(Request $request)
    {
        $resource = $this->findOr404();
        return $this->view($resource);
    }

    protected function createViewFromPaginator(Pagerfanta $paginator, Request $request)
    {
        $paginator->setCurrentPage($request->get('page', 1), true, true);
        $paginator->setMaxPerPage($request->get('limit', 20));
        $paginator = $this->getPagerfantaFactory()
            ->createRepresentation($paginator, new Route(
                $request->attributes->get('_route'),
                $request->attributes->get('_route_params')
            ));

        return $this->view($paginator);
    }
    
    protected function createPaginatedViewFromArray(array $array, Request $request)
    {
        $paginator = new Pagerfanta(new ArrayAdapter($array));
        return $this->createViewFromPaginator($paginator, $request);
    }

    protected function findOr404($id = null)
    {
        if (null === $resource =$this->findOrNull($id)) {
            throw $this->createNotFoundException();
        }
        return $resource;
    }

    protected function findOrNull($id = null)
    {
        if (null === $id) {
            $id = $this->getRequest()->get('id');
        }
        $criteria = array('id' => $id);
        return $this->getRepository()->findOneBy($criteria);
    }

    /**
     * @return \DoubleGis\TestBundle\Doctrine\ORM\ResourceRepository
     */
    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository($this->getResourceClass());
    }

    /**
     * @return PagerfantaFactory
     */
    protected function getPagerfantaFactory()
    {
        return new PagerfantaFactory('page', 'limit');
    }

    protected function getRequest()
    {
        return $this->container->get('request_stack')->getCurrentRequest();
    }

    protected function view($data = null, $statusCode = null, array $headers = [])
    {
        $view = parent::view($data, $statusCode, $headers);
        $view->getContext()->addGroup('Default');
        $scopes = $this->getRequest()->get('scope', null);
        if (null !== $scopes) {
            $scopes = explode(',', $scopes);
            foreach($scopes as $scope) {
                $view->getContext()->addGroup($scope);
            }
        }
        return $view;
    }


    abstract protected function getResourceClass();
}
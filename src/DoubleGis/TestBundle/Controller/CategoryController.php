<?php

namespace DoubleGis\TestBundle\Controller;

use DoubleGis\TestBundle\Controller\ResourceController;
use FOS\RestBundle\Request\ParamFetcher;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class CategoryController extends ResourceController
{

    /**
     * Get list of categories.
     *
     * @ApiDoc(
     *  resource = true,
     *  output = {
     *      "class" = "DoubleGis\TestBundle\Entity\Category",
     *      "collection" = true,
     *      "collectionName" = "categories",
     *  },
     *  filters={
     *      {"name"="scope", "dataType"="string", "pattern"="(tree|null)", "description"="Optional scope for returned categories. Can be null or 'tree'. In tree scope each category will have embedded array of it's direct children."}
     *  },
     *  statusCodes = {
     *    200 = "",
     *    404 = "When organization with a given parent_id or ancestor_id ID does not exist"
     *  }
     * )
     * @QueryParam(name="parent_id", requirements="\d+", strict=true, description="ID of a category which direct children to get", nullable=true)
     * @QueryParam(name="ancestor_id", requirements="\d+", strict=true, description="ID of a category which descendants to get", nullable=true)
     */
    public function getCategoriesAction(ParamFetcher $paramFetcher, Request $request)
    {
        if (null !== $parent = $this->findOrNull($paramFetcher->get('parent_id'))) {
            $view = $this->createPaginatedViewFromArray($parent->getChildren()->toArray(), $request);
            return $view;
        }
        if (null !== $ancestor = $this->findOrNull($paramFetcher->get('ancestor_id'))) {
            $resources = $this->getRepository()->children($ancestor);
            $view = $this->createPaginatedViewFromArray($resources, $request);
            return $view;
        }
        return $this->indexAction($request);
    }

    /**
     * Get a single category
     *
     * @ApiDoc(
     *  resource = true,
     *  scope="write|admin|object_manager",
     *  requirements = {
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "description"="Category ID"
     *      }
     *  },
     *  filters={
     *      {"name"="scope", "dataType"="string", "pattern"="(tree|null)", "description"="Optional scope for returned category. Can be null or 'tree'. In tree scope category will have embedded array of it's direct children."}
     *  },
     *  output = {
     *      "class" = "DoubleGis\TestBundle\Entity\Category"
     *  },
     *  statusCodes = {
     *    200 = "",
     *    404 = "When category with a given ID does not exist"
     *  }
     * )
     */
    public function getCategoryAction(Request $request, $id)
    {
        return $this->showAction($request);
    }

    protected function getResourceClass()
    {
        return 'DoubleGis\TestBundle\Entity\Category';
    }
}
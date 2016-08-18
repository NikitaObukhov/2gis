<?php

namespace DoubleGis\TestBundle\Doctrine\ORM;

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use DoubleGis\TestBundle\Entity\Category;
use DoubleGis\TestBundle\Utils\Circle;
use DoubleGis\TestBundle\Utils\Polygon;
use FOS\RestBundle\Request\ParamFetcher;

class OrganizationSearchParams
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var Circle
     */
    private $circle;

    /**
     * @var Polygon
     */
    private $polygon;

    /**
     * @var Category
     */
    private $category;

    /**
     * @var Category
     */
    private $categoryAncestor;

    /**
     * @var Category[]
     */
    private $descendantsOfCategory;

    private function __construct($name = null, Circle $circle = null, Polygon $polygon = null, Category $category = null, Category $categoryAncestor = null, $descendantsOfCategory = null)
    {
        $this->name = $name;
        $this->circle = $circle;
        $this->polygon = $polygon;
        $this->category = $category;
        $this->categoryAncestor = $categoryAncestor;
        $this->descendantsOfCategory = $descendantsOfCategory;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Circle
     */
    public function getCircle()
    {
        return $this->circle;
    }

    /**
     * @return Polygon
     */
    public function getPolygon()
    {
        return $this->polygon;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return Category
     */
    public function getCategoryAncestor()
    {
        return $this->categoryAncestor;
    }

    /**
     * @return \DoubleGis\TestBundle\Entity\Category[]
     */
    public function getDescendantsOfCategory()
    {
        return $this->descendantsOfCategory;
    }

    public static function createFromParamFetcher(ParamFetcher $paramFetcher, CategoryRepository $categoryRepo)
    {

        $name = $paramFetcher->get('name');
        $circle = $paramFetcher->get('circle');
        $polygon = $paramFetcher->get('polygon');
        $categoryId = $paramFetcher->get('category_id');
        $categoryAncestorId = $paramFetcher->get('category_ancestor_id');
        $category = null;
        $categoryAncestor = null;
        $descendantsOfCategory = null;
        if (null !== $categoryId && null === ($category = $categoryRepo->findOneById($categoryId))) {
            throw EntityNotFoundException::fromClassNameAndIdentifier('DoubleGis\TestBundle\Entity\Category', array(
                'id' => $categoryId,
            ));
        }
        if (null !== $categoryAncestorId && null === ($categoryAncestor = $categoryRepo->findOneById($categoryAncestorId))) {
            throw EntityNotFoundException::fromClassNameAndIdentifier('DoubleGis\TestBundle\Entity\Category', array(
                'id' => $categoryAncestorId,
            ));
        }
        if (isset($categoryAncestor)) {
            $descendantsOfCategory = $categoryRepo->children($categoryAncestor);
        }
        return new self($name, $circle, $polygon, $category, $categoryAncestor, $descendantsOfCategory);
    }
}
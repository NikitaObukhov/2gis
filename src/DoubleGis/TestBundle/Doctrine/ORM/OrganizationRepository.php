<?php

namespace DoubleGis\TestBundle\Doctrine\ORM;

use Doctrine\ORM\EntityRepository;
use DoubleGis\TestBundle\Entity\Category;
use DoubleGis\TestBundle\Utils\Circle;
use DoubleGis\TestBundle\Utils\Polygon;
use FOS\RestBundle\Request\ParamFetcher;

class OrganizationRepository extends EntityRepository
{

    use ResourceRepositoryTrait;

    const EARTH_RADIUS_M = 6378145;

    public function findByParams(OrganizationSearchParams $searchParams)
    {
        $qb = $this->createQueryBuilderForParams($searchParams);
        $organizations = $qb->getQuery()->getResult();
        return $organizations;
    }

    public function findByParamsAndPaginate(OrganizationSearchParams $searchParams)
    {
        $qb = $this->createQueryBuilderForParams($searchParams);
        return $this->getPaginator($qb);
    }

    public function createQueryBuilderForParams(OrganizationSearchParams $searchParams)
    {
        $qb = $this->createQueryBuilder('o');
        if (null !== $searchParams->getName()) {
            $qb->where('LOWER(o.name) LIKE :name');
            $qb->setParameter('name', '%'.$searchParams->getName().'%');
        }

        $circle = $searchParams->getCircle();
        $polygon = $searchParams->getPolygon();
        if (null !== $circle || null !== $polygon) {
            $qb->join('o.building', 'b');
            $qb->join('b.address', 'a');
        }
        if (null !== $circle) {
            $qb->andWhere(
                sprintf('(%s * acos(cos(radians(:lat)) * cos(radians(a.lat)) * cos(radians(:lon) -
                radians(a.lon)) + sin(radians(a.lat)) * sin(radians(:lat)))) < :distance', self::EARTH_RADIUS_M)
            );
            $qb->setParameter('distance', $circle->getRadius())
                ->setParameter('lat', $circle->getX())
                ->setParameter('lon', $circle->getY());
        }
        $category = $searchParams->getCategory();
        $categoryAncestor = $searchParams->getCategoryAncestor();
        if (null !== $category || null !== $categoryAncestor) {
            $qb->leftJoin('o.categories', 'c');
        }
        if (null !== $category) {
            $qb->andWhere('c.id = :categoryId');
            $qb->setParameter('categoryId', $category->getId());
        }
        if (null !== $categoryAncestor) {
            $descendants = $searchParams->getDescendantsOfCategory();
            $qb->andWhere('c.id IN(:categoryIds)');
            $categoryIds = array_map(function(Category $category) {
                return $category->getId();
            }, $descendants);
            $qb->setParameter('categoryIds', $categoryIds);
        }
        if (null !== $polygon) {
            $polygonAsString = '';
            foreach($polygon->getDots() as $dot) {
                $polygonAsString .= floatval($dot[0]) .' '. floatval($dot[1]) .',';
            }
            $polygonAsString = rtrim($polygonAsString, ',');
            // CrEOF\Spatial\ORM\Query\AST\Functions\AbstractSpatialDQLFunction does not handle parameters
            // so we directly define polygon in where clause. This is safe because all dots were casted to float.
            $qb->andWhere(sprintf('st_contains(st_geomfromtext(\'polygon((%s))\'), Point(a.lat, a.lon)) = 1', $polygonAsString));
        }
        return $qb;
    }
}
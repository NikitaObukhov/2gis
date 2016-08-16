<?php

namespace DoubleGis\TestBundle\Doctrine\ORM;

use DoubleGis\TestBundle\Utils\Circle;
use DoubleGis\TestBundle\Utils\Polygon;
use FOS\RestBundle\Request\ParamFetcher;

class OrganizationRepository extends ResourceRepository
{

    const EARTH_RADIUS_M = 6378145;

    public function findByParams($name = null, Circle $circle = null, Polygon $polygon = null)
    {
        $qb = $this->createQueryBuilder('o');
        if (null !== $name) {
            $qb->where('LOWER(o.name) LIKE :name');
            $qb->setParameter('name', '%'.$name.'%');
        }

        $findByCircle= false;
        if (null !== $circle || null !== $polygon) {
            $qb->join('o.building', 'b');
            $qb->join('b.address', 'a');
        }
        if (null !== $circle) {
            /* @var $circle \DoubleGis\TestBundle\Utils\Circle */
            $findByCircle = true;
            $qb->addSelect(
                sprintf('(%s * acos(cos(radians(:lat)) * cos(radians(a.lat)) * cos(radians(:lon) -
                radians(a.lon)) + sin(radians(a.lat)) * sin(radians(:lat)))) as distance', self::EARTH_RADIUS_M)
            );
            $qb->setParameter('distance', $circle->getRadius())
                ->setParameter('lat', $circle->getX())
                ->setParameter('lon', $circle->getY());
            $qb->orderBy('distance', 'ASC');
            $qb->having('distance < :distance');
        }
        if (null !== $polygon) {
            /* @var $polygon \DoubleGis\TestBundle\Utils\Polygon */
            $polygonAsString = '';
            foreach($polygon->getDots() as $dot) {
                $polygonAsString .= floatval($dot[0]) .' '. floatval($dot[1]) .',';
            }
            $polygonAsString = rtrim($polygonAsString, ',');
            // CrEOF\Spatial\ORM\Query\AST\Functions\AbstractSpatialDQLFunction does not handle parameters
            // so we directly define polygon in where clause. This is safe because all dots were casted to float.
            $qb->where(sprintf('st_contains(st_geomfromtext(\'polygon((%s))\'), Point(a.lat, a.lon)) = 1', $polygonAsString));
        }
        $organizations = $qb->getQuery()->getResult();
        if ($findByCircle) {
            // We added distance field so we have array of arrays not objects.
            $organizations = array_map(function ($organization) {
                 return array_shift($organization);
            }, $organizations);
        }
        return $organizations;
    }
}
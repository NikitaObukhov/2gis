<?php

namespace DoubleGis\TestBundle\Controller\Annotations;

use Doctrine\DBAL\Exception\ConstraintViolationException;
use DoubleGis\TestBundle\Utils\Polygon;
use FOS\RestBundle\Controller\Annotations\AbstractParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
class PolygonParam extends QueryParam
{
    public $mustBeClosed = true;

    public function getConstraints()
    {
        $constraints = parent::getConstraints();
        $that = $this;
        $constraint = new Callback(['callback' => function(Polygon $polygon) use ($that) {
            if ($that->mustBeClosed && false === $polygon->isClosed()) {
                throw new ValidatorException('Polygon is not closed.');
            }
        }]);
        $constraints[] = $constraint;
        return $constraints;
    }

    public function isStrict()
    {
        return true;
    }


    /**
     * Get param value in function of the current request.
     *
     * @param Request $request
     * @param mixed $default value
     *
     * @return mixed
     */
    public function getValue(Request $request, $default)
    {
        if (null === $param = parent::getValue($request, $default)) {
            return null;
        }
        return Polygon::createFromString($param);
    }
}
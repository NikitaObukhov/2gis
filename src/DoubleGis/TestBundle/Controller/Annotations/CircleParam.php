<?php

namespace DoubleGis\TestBundle\Controller\Annotations;

use DoubleGis\TestBundle\Utils\Circle;
use FOS\RestBundle\Controller\Annotations\AbstractParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
class CircleParam extends QueryParam
{

    public function getConstraints()
    {
        $that = $this;
        $constraint = new Callback(['callback' => function(Circle $circle = null) use ($that) {
            if ($circle) {
                if ($circle->getRadius() <= 0) {
                    throw new ValidatorException('Circle radius must be positive number.');
                }
                if ('' === trim($circle->getX()) || '' === trim($circle->getY())) {
                    throw new ValidatorException('Invalid circle center coordinates.');
                }
            }
        }]);
        return array($constraint);
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
        if (null === $param = $request->query->get($this->getKey(), $default)) {
            return null;
        }
        return Circle::createFromString($param);
    }
}
<?php

namespace DoubleGis\TestBundle\Controller\Annotations;

use DoubleGis\TestBundle\Utils\Circle;
use FOS\RestBundle\Controller\Annotations\AbstractParam;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
class CircleParam extends AbstractParam
{

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
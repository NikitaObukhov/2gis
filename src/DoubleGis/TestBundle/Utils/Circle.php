<?php

namespace DoubleGis\TestBundle\Utils;


class Circle
{
    private $radius;

    private $x;

    private $y;

    public function __construct($radius, $x, $y)
    {
        $this->radius = $radius;
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return mixed
     */
    public function getRadius()
    {
        return $this->radius;
    }

    /**
     * @param mixed $radius
     */
    public function setRadius($radius)
    {
        $this->radius = $radius;
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param mixed $x
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param mixed $y
     */
    public function setY($y)
    {
        $this->y = $y;
    }

    public static function createFromString($string)
    {
        list($radius, $x, $y) = explode(',', $string);
        return new static($radius, $x, $y);
    }
}
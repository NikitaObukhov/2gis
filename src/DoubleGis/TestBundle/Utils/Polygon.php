<?php

namespace DoubleGis\TestBundle\Utils;


class Polygon
{

    private $dots = array();

    public function __construct(array $dots = array())
    {
        foreach($dots as $dot) {
            $this->addDot($dot[0], $dot[1]);
        }
    }

    public function addDot($x, $y)
    {
        $this->dots[] = [trim($x), trim($y)];
        return $this;
    }

    public function isClosed()
    {
        $lastDot = end($this->dots);
        return $this->dots[0][0] === $lastDot[0] && $this->dots[0][1] === $lastDot[1];
    }

    /**
     * @return array
     */
    public function getDots()
    {
        return $this->dots;
    }

    /**
     * @param array $dots
     */
    public function setDots($dots)
    {
        $this->dots = $dots;
    }

    public static function createFromString($string)
    {
        $polygon = new self();
        foreach(explode(';', $string) as $dot) {
            list($x, $y) = explode(',', $dot);
            $polygon->addDot($x, $y);
        }
        return $polygon;
    }
}
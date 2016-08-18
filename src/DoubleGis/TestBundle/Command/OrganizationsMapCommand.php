<?php

namespace DoubleGis\TestBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Jaguar\Drawable\Pixel,
    Jaguar\Color\RGBColor,
    Jaguar\Dimension,
    Jaguar\Coordinate,
    Jaguar\Canvas;

class OrganizationsMapCommand extends Command
{

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $w = 200;
        $h = 200;

        $canvas = new Canvas(new Dimension($w, $h));
        $pixel = new Pixel();
        $pixel->setColor(RGBColor::fromHex('#f00'));

        $corners[0] = array('x' => 100, 'y' => 10);
        $corners[1] = array('x' => 0, 'y' => 190);
        $corners[2] = array('x' => 200, 'y' => 190);


        for ($i = 0; $i < 100000; $i++) {

            $pixel->setCoordinate(new Coordinate(round($w), round($h)))
                ->draw($canvas);

            $a = rand(0, 2);
            $w = ($w + $corners[$a]['x']) / 2;
            $h = ($h + $corners[$a]['y']) / 2;
        }

        $canvas->save(null);
    }

    public function configure()
    {

        $this
            ->setName('2gis:organizations:map')
            ->setDescription('Show organizations on ASCII map');
    }
}
<?php

namespace DoubleGis\TestBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DoubleGis\TestBundle\Entity\Building;

class LoadBuildingData implements FixtureInterface, DependentFixtureInterface
{


    public function load(ObjectManager $manager)
    {
        $addresses = $manager->getRepository('DoubleGis\TestBundle\Entity\Address')->findAll();
        foreach($addresses as $key => $address) {
            $building = new Building();
            $building->setAddress($address);
            $manager->persist($building);
            if (0 === $key % 100) {
                $manager->flush();
            }
        }
        $manager->flush();
    }


    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    function getDependencies()
    {
        return array('DoubleGis\TestBundle\DataFixtures\ORM\LoadAddressData');
    }
}
<?php

namespace DoubleGis\TestBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DoubleGis\TestBundle\Entity\Organization;

class LoadOrganizationData implements FixtureInterface, DependentFixtureInterface
{


    public function load(ObjectManager $manager)
    {
        $buildings = $manager->getRepository('DoubleGis\TestBundle\Entity\Building')->findAll();
        $categories = $manager->getRepository('DoubleGis\TestBundle\Entity\Category')->findAll();
        /* @var $buildings \DoubleGis\TestBundle\Entity\Building[] */
        /* @var $categories \DoubleGis\TestBundle\Entity\Category[] */
        $i = 0;
        foreach($buildings as $building) {
            for ($j = 0, $orgsInBuilding = mt_rand(1, 30); $j < $orgsInBuilding; $j++) {
                $organization = new Organization();
                $organization->setName('Organization #'. $i);
                $organization->setBuilding($building);
                $categoryKeys = array_rand($categories, mt_rand(1, 5));
                if (!is_array($categoryKeys)) {
                    $categoryKeys = array($categoryKeys);
                }
                foreach($categoryKeys as $categoryKey) {
                    $organization->addCategory($categories[$categoryKey]);
                }
                $manager->persist($organization);
                if (0 === $i % 100) {
                    $manager->flush();
                }
                ++$i;
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
        return [
            'DoubleGis\TestBundle\DataFixtures\ORM\LoadBuildingData',
            'DoubleGis\TestBundle\DataFixtures\ORM\LoadCategoryData',
        ];
    }
}
<?php

namespace DoubleGis\TestBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DoubleGis\TestBundle\Entity\Organization;
use DoubleGis\TestBundle\Entity\PhoneNumber;

class LoadOrganizationData implements FixtureInterface, DependentFixtureInterface
{


    public function load(ObjectManager $manager)
    {
        $buildings = $manager->getRepository('DoubleGis\TestBundle\Entity\Building')->matching(Criteria::create()); // ~500-1000
        $categories = $manager->getRepository('DoubleGis\TestBundle\Entity\Category')->findAll();
        /* @var $buildings \DoubleGis\TestBundle\Entity\Building[] */
        /* @var $categories \DoubleGis\TestBundle\Entity\Category[] */
        $i = 0;
        $connection = $manager->getConnection();
        /* @var $connection \Doctrine\DBAL\Connection */
        $connection->setAutoCommit(false);
        print 'This will take some time, please be patient'. PHP_EOL;
        foreach($buildings as $building) {
            for ($j = 0, $orgsInBuilding = mt_rand(200, 250); $j < $orgsInBuilding; $j++) {
                $organization = new Organization();
                $organization->setName('Organization #'. $i);
                $organization->setBuilding($building);
                for($p = 0, $orgPhones = mt_rand(0, 3); $p < $orgPhones; $p++) {
                    $phoneNumber = new PhoneNumber();
                    $phoneNumber->setNumber($this->generateRandomPhoneNumber());
                    $organization->addPhone($phoneNumber);
                    $manager->persist($phoneNumber);
                }
                $categoryKeys = array_rand($categories, mt_rand(1, 5));
                if (!is_array($categoryKeys)) {
                    $categoryKeys = array($categoryKeys);
                }
                foreach($categoryKeys as $categoryKey) {
                    $organization->addCategory($categories[$categoryKey]);
                }
                $manager->persist($organization);
                if (0 === $i % 100) {
                    // We generate approximately 10^4 organizations.
                    if (0 === $i % 1700) {
                        $percentage = floor($i / 1700);
                        if ($percentage > 100) { // Because we generate random number it may happen sometimes :)
                            print $percentage. '% (end is near)'. PHP_EOL;
                        }
                        else {
                            print $percentage. '%'. PHP_EOL;
                        }
                        $connection->commit();
                    }
                    $manager->flush();
                    $manager->clear('DoubleGis\TestBundle\Entity\Organization');
                    $manager->clear('DoubleGis\TestBundle\Entity\PhoneNumber');
                }
                ++$i;
            }
        }
        print 'Done.'.PHP_EOL;
        $manager->flush();
    }

    protected function generateRandomPhoneNumber($length = 10)
    {
        $phoneNumber = '';
        for($i = 0; $i < $length; $i++) {
            $phoneNumber .= mt_rand(0, 9);
        }
        return $phoneNumber;
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
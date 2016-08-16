<?php

namespace DoubleGis\TestBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DoubleGis\TestBundle\Entity\PhoneNumber;

class LoadPhoneNumberData implements FixtureInterface, DependentFixtureInterface
{


    public function load(ObjectManager $manager)
    {
        $organizations = $manager->getRepository('DoubleGis\TestBundle\Entity\Organization')->findAll();
        /* @var $organizations \DoubleGis\TestBundle\Entity\Organization[] */
        $j = 0;
        foreach($organizations as $organization) {
            for($i = 0, $orgPhones = mt_rand(0, 3); $i < $orgPhones; $i++) {
                $phoneNumber = new PhoneNumber();
                $phoneNumber->setNumber($this->generateRandomPhoneNumber());
                $organization->addPhone($phoneNumber);
                $manager->persist($phoneNumber);
                if (0 === $j % 100 ) {
                    $manager->flush();
                }
                ++$j;
            }
        }
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
        return array('DoubleGis\TestBundle\DataFixtures\ORM\LoadOrganizationData');
    }
}
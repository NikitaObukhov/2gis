<?php

namespace DoubleGis\TestBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use DoubleGis\TestBundle\Entity\Address;

class LoadAddressData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $streets = [
            'Красный проспект',
            'Оранжевый проспект',
            'Жёлтый проспект',
            'Зеленый проспект',
            'Голубой проспект',
            'Синий проспект',
            'Фиолетовый проспект',
        ];
        $j = 0;
        $lat = 55;
        $lon = 83;
        $connection = $manager->getConnection();
        /* @var $connection \Doctrine\DBAL\Connection */
        $connection->setAutoCommit(false);
        foreach($streets as $street) {
            $lat += 0.005;
            for ($i = 0, $max = mt_rand(80, 140); $i < $max; $i++) {
                $lon += 0.005;
                $address = new Address();
                $address->setStreet($street);
                $address->setLon($lon);
                $address->setLat($lat);
                if (mt_rand(0, 10) > 8) {
                    $address->setHouse($i);
                    ++$j;
                    $manager->persist($address);
                }
                elseif ($i % 2) {
                    $address->setHouse($i . '/'. mt_rand(1, 10)); // They probably use the same naming algorithm
                    ++$j;
                    $manager->persist($address);
                }
                if (0 === $j % 100) {
                    $manager->flush();
                    $manager->clear('DoubleGis\TestBundle\Entity\Address');
                    $connection->commit();
                }
            }
        }
        $manager->flush();
    }



}
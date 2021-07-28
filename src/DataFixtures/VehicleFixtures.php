<?php

namespace App\DataFixtures;

use App\Entity\Vehicle;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class VehicleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $vehicle = new Vehicle();
            $vehicle
                ->setTitle('BMW Série 3 de test '.$i)
                ->setBrand('BMW')
                ->setModel('Série 3')
                ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.')
                ->setDailyPrice(200 * (( 1 + $i ) / 2 ))
            ;
            $manager->persist($vehicle);
        }

        $manager->flush();
    }
}

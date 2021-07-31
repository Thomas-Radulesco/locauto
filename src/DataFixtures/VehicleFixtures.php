<?php

namespace App\DataFixtures;

use App\Entity\Vehicle;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class VehicleFixtures extends Fixture
{
    
    public const VEHICLE_X = 'x';
    public const VEHICLE_Y = 'y';
    public const VEHICLE_Z = 'z';

    public function load(ObjectManager $manager)
    {
        
        $vehicleX = new Vehicle();
        $vehicleX
            ->setTitle('X')
            ->setBrand('BMW')
            ->setModel('Série 3 de test X')
            ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.')
            ->setDailyPrice(200)
        ;
        $manager->persist($vehicleX);
       
        $vehicleY = new Vehicle();
        $vehicleY
            ->setTitle('Y')
            ->setBrand('BMW')
            ->setModel('Série 3 de test Y')
            ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.')
            ->setDailyPrice(100)
        ;
        $manager->persist($vehicleY);

        $vehicleZ = new Vehicle();
        $vehicleZ
            ->setTitle('Z')
            ->setBrand('BMW')
            ->setModel('Série 3 de test Z')
            ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.')
            ->setDailyPrice(300)
        ;
        $manager->persist($vehicleZ);



        $manager->flush();

        $this->addReference(self::VEHICLE_X, $vehicleX);
        $this->addReference(self::VEHICLE_Y, $vehicleY);
        $this->addReference(self::VEHICLE_Z, $vehicleZ);
    }
}

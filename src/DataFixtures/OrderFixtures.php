<?php

namespace App\DataFixtures;

use DateTime;
use DateInterval;
use App\Entity\Order;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $referenceDate = new DateTime();
        $datetimeFromX = $referenceDate->add(new DateInterval('P4D')); // la période de location commence dans 4 jours (P: period; 4: 4; D: days) 
        $referenceDate = new DateTime();
        $datetimeToX = $referenceDate->add(new DateInterval('P11D')); // la période de location finit dans 11 jours
        $referenceDate = new DateTime();
        $datetimeFromY = $referenceDate->add(new DateInterval('P2D'));
        $referenceDate = new DateTime();
        $datetimeToY = $referenceDate->add(new DateInterval('P9D'));

        $referenceDate = new DateTime();
        $datetimeFromZ = $referenceDate->add(new DateInterval('P3D'));
        $referenceDate = new DateTime();
        $datetimeToZ = $referenceDate->add(new DateInterval('P7D'));
        
        $orderX = new Order();
        $orderX
            ->setDatetimeFrom($datetimeFromX)
            ->setDatetimeTo($datetimeToX)
            ->setMemberId($this->getReference(UserFixtures::ADMIN))
            ->setVehicleId($this->getReference(VehicleFixtures::VEHICLE_X))
            ->setTotalPrice(1400)
        ;

        $orderY = new Order();
        $orderY
            ->setDatetimeFrom($datetimeFromY)
            ->setDatetimeTo($datetimeToY)
            ->setMemberId($this->getReference(UserFixtures::ADMIN))
            ->setVehicleId($this->getReference(VehicleFixtures::VEHICLE_Y))
            ->setTotalPrice(700)
        ;

        $orderZ = new Order();
        $orderZ
            ->setDatetimeFrom($datetimeFromZ)
            ->setDatetimeTo($datetimeToZ)
            ->setMemberId($this->getReference(UserFixtures::ADMIN))
            ->setVehicleId($this->getReference(VehicleFixtures::VEHICLE_Z))
            ->setTotalPrice(1200)
        ;

        $manager->persist($orderX);
        $manager->persist($orderY);
        $manager->persist($orderZ);

        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            UserFixtures::class,
            VehicleFixtures::class,
        ];
    }
}

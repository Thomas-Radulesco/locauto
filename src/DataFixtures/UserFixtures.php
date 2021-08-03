<?php

namespace App\DataFixtures;

use App\Entity\Member;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $userPasswordHasherInterface;
    public const ADMIN = 'admin';
    public const USER = 'user';

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new Member();

        $admin
            ->setLogin('Tom')
            ->setEmailAddress('tomr_99@hotmail.com')
            ->setFirstName('Thomas')
            ->setLastName('Radulesco')
            ->setRoles(['ROLE_ADMIN', 'ROLE_USER'])
            ->setGender('Homme')
            ->setPassword($this->userPasswordHasherInterface->hashPassword($admin, 'TestPasswordAdmin123%'))
        ;
        
        $manager->persist($admin);
        
        $user = new Member();
        
        $user
        ->setLogin('Yolo')
        ->setEmailAddress('yolo@yolo.com')
        ->setFirstName('Yolo')
        ->setLastName('Yoloyolo')
        ->setRoles(['ROLE_USER'])
        ->setGender('Femme')
        ->setPassword($this->userPasswordHasherInterface->hashPassword($user, 'TestPasswordUser123%'))
        ;
        
        $manager->persist($user);
        
        $manager->flush();
        
        $this->addReference(self::ADMIN, $admin);
        $this->addReference(self::USER, $user);
    }
}

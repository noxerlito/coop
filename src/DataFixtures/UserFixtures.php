<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $admin = new User();
        $admin
            ->setEmail('admin@coop.com')
            ->setFirstName('Admin')
            ->setLastName('Coop')
            ->setPassword($this->hasher->hashPassword($admin, 'admin'))
            ->setRoles(['ROLE_ADMIN'])
        ;

        $manager->persist($admin);

        for ($i = 0; $i < 20; ++$i) {
            $user = new User();
            $user
                ->setEmail($faker->email())
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setPassword($this->hasher->hashPassword($user, 'admin'))
            ;

            $manager->persist($user);
        }

        $manager->flush();
    }
}

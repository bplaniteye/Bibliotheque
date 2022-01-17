<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($u=0; $u<1000; $u++)
        {
            $user = new User;
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setBirthday($faker->dateTimeBetween());
            $user->setEmail($faker->email());
            $user->setPassword($faker->password());
            $user->setAddress($faker->address());
            $manager->persist($user);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
       return ['user'];
    }
}

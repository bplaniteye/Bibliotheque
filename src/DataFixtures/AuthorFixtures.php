<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($a=0; $a<1000; $a++)
        {
            $author = new Author();
            $author->setFirstname($faker->firstName());
            $author->setLastname($faker->lastName());            
            $author->setEmail($faker->email());
            $author->setPassword($faker->password()); 
            $author->setImageName($faker->company());         
            $manager->persist($author);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['author'];
    }
}

<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CategoryFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $cat = ["Roman", "BD", "Recueil", "Essai", "Magazine", "Journal"];
        $nbcat = count($cat);

        for ($c = 0; $c < $nbcat; $c++) 
        {
            $category = new Category();
            $category->setLabel($cat[$c]);
            $manager->persist($category);
            $manager->flush();
        }
    }
    public static function getGroups(): array
    {
       return ['category'];
    }
}

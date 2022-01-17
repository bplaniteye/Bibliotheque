<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $cat = ["Roman", "BD", "Recueil", "Essai", "Magazine", "Journal"];
        $nbcat = count($cat);

        // Category fixtures
        for ($c=0; $c<$nbcat; $c++) 
        {
            $category = new Category();
            $category->setLabel($cat[$c]);
            $manager->persist($category);

            // Article fixtures
            for ($a = 0; $a < 5; $a++) 
            {
                $article = new Article();
                $article->setTitle($faker->sentence($nbwords=mt_rand(1,10) , $variablewords = true ));
                $article->setDatetime($faker->dateTimeBetween());                          
                $article->setContent($faker->words($nb=mt_rand(200,500) , $asText=true));
                $article->setCategory($category);
                //$article->setImage($faker->imageUrl());
                $manager->persist($article);

                // Comment fixture
                for ($com=0; $com<5; $com++)
                {
                    $comment = new Comment;
                    $comment->setContent($faker->words($nb=100, $asText=true));
                    $comment->setDatetime($faker->dateTimeBetween());
                    $comment->setArticle($article);
                    $manager->persist($comment);
                }
            }
        }

        // User fixtures
        for ($u=0; $u<50; $u++)
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
}

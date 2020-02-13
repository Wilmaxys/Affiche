<?php

namespace App\DataFixtures;

use App\Entity\Products;
use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i =0; $i < 10; $i++)
        {
            $Category = new Categories();
            $Category->setNom($faker->words(3, true));
            $Category->setDescription($faker->words(3, true));
            $Category->setImageName(" ");
            $Category->setImageSize(4);
            $manager->persist($Category);
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Products;
use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $CategoryRetrive = $manager->getRepository(Categories::class)->findAll();

        for ($i =0; $i < 300; $i++)
        {
            $Product = new Products();
            $Product
                ->setNom($faker->words(3, true))
                ->setDescription($faker->sentences(3,true))
                ->setPrixHT($faker->numberBetween(100,300))
                ->setPrixTTC($faker->numberBetween(400,500))
                ->setCategory($CategoryRetrive[random_int(0,9)])
                ->setStock(random_int(20,400))
                ->setImageSize(4)
                ->setImageName(" ");
            $manager->persist($Product);
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return array(
            CategoryFixture::class
        );
    }
}

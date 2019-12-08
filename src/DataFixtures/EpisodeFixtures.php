<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use App\Service\Slugify;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $episode = new episode();
            $episode->setTitle($faker->sentence($nbWords = 6, $variableNbWords = true));
            $episode->setSynopsis($faker->sentence($nbWords = 6, $variableNbWords = true));
            $episode->setNumber($i);
            $episode->setSynopsis($faker->paragraph);
            $slugify = new Slugify();
            $episode->setSlug($slugify->generate($episode->getTitle()));
            $episode->setSeason($this->getReference('season_'.random_int(0,19)));
            $manager->persist($episode);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}

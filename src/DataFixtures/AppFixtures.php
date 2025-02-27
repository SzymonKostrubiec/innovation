<?php

namespace App\DataFixtures;

use App\Entity\Configuration;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadConfiguration($manager);
    }

    private function loadConfiguration(ObjectManager $manager): void
    {
        $configuration = new Configuration();
        $configuration->setMonthlyNormHours(40);
        $configuration->setHourlyRate(random_int(1000, 5000));
        $configuration->setOvertimeMultiplier(random_int(150, 300));

        $manager->persist($configuration);
        $manager->flush();
    }
}
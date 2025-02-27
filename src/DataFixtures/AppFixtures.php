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
        $configuration->setHourlyRate(20);
        $configuration->setOvertimeMultiplier(200);

        $manager->persist($configuration);
        $manager->flush();
    }
}
<?php

namespace App\DataFixtures;

use App\Factory\DispatchAreaFactory;
use App\Factory\StateFactory;
use App\Factory\SupplyAreaFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        StateFactory::createMany(5);
        SupplyAreaFactory::createMany(5);
        DispatchAreaFactory::createMany(35);

        $manager->flush();
    }
}

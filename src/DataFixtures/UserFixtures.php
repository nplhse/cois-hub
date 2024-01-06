<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::new(['username' => 'admin'])->asAdmin()->create();

        UserFactory::new(['username' => 'foo'])->create();

        $manager->flush();
    }
}

<?php

namespace App\Tests\Integration\Controller\Data\Hospital;

use App\Factory\DispatchAreaFactory;
use App\Factory\HospitalFactory;
use App\Factory\StateFactory;
use App\Factory\SupplyAreaFactory;
use App\Factory\UserFactory;
use App\Tests\AppWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class HospitalShowControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testUsersCanViewHospitals(): void
    {
        // Arrange
        StateFactory::createOne();
        SupplyAreaFactory::createOne();
        DispatchAreaFactory::createOne();

        $state = StateFactory::random();
        $dispatchArea = DispatchAreaFactory::random();

        UserFactory::createOne();
        $hospital = HospitalFactory::createOne();

        // Act& Assert
        $this->browser()
            ->actingAs(UserFactory::new()->asAdmin()->create()->object())
            ->visit('/data/hospital/'.$hospital->getId())
            ->assertSuccessful()
            ->assertSeeIn('.fw-bold', $hospital->getName())
            ->assertSeeIn('.list-inline-item', $dispatchArea->getName())
            ->assertSeeIn('.list-inline-item', $state->getName())
            ->assertSee($hospital->getSize()->value)
            ->assertSee($hospital->getLocation()->value)
            ->assertSee($hospital->getSize()->value)
        ;
    }
}

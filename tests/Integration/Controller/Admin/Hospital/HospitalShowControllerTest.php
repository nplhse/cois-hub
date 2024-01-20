<?php

namespace App\Tests\Integration\Controller\Admin\Hospital;

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

    public function testAdminsCanViewHospitals(): void
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
            ->visit('/admin/hospital/'.$hospital->getId())
            ->assertSuccessful()
            ->assertSeeIn('h2', 'Hospitals')
            ->assertSeeIn('div', $hospital->getName())
            ->assertSeeIn('div', $state->getName())
            ->assertSeeIn('div', $dispatchArea->getName())
        ;
    }
}

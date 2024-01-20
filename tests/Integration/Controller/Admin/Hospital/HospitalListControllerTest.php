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

class HospitalListControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testAdminsCanSeeAListOfAllHospitals(): void
    {
        // Arrange
        StateFactory::createOne();
        SupplyAreaFactory::createOne();
        DispatchAreaFactory::createOne();

        UserFactory::createOne();
        HospitalFactory::createMany(5);

        $randomHospital = HospitalFactory::random();

        // Act& Assert
        $this->browser()
            ->actingAs(UserFactory::new()->asAdmin()->create()->object())
            ->visit('/admin/hospital/')
            ->assertSuccessful()
            ->assertSeeIn('h2', 'Hospitals')
            ->assertSee($randomHospital->getName())
            ->assertSee('Showing 5 results, with 10 per page.')
        ;
    }
}

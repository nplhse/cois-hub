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

class HospitalEditControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testAdminsCanCreateANewHospital(): void
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
            ->visit('/admin/hospital/'.$hospital->getId().'/edit')
            ->assertSuccessful()
            ->assertSeeIn('title', 'Edit Hospital')
            ->fillField('Name', 'Another Demo Hospital')
            ->click('Save changes')
            ->assertSuccessful()
            ->assertSee('Success! The Hospital has been updated.')
            ->assertSeeIn('div', 'Another Demo Hospital')
        ;
    }
}

<?php

namespace App\Tests\Integration\Controller\Data\Hospital;

use App\Factory\DispatchAreaFactory;
use App\Factory\StateFactory;
use App\Factory\SupplyAreaFactory;
use App\Factory\UserFactory;
use App\Tests\AppWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class HospitalNewControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testParticipantsCanCreateANewHospital(): void
    {
        // Arrange
        StateFactory::createOne();
        SupplyAreaFactory::createOne();
        DispatchAreaFactory::createOne();

        $state = StateFactory::random();
        $dispatchArea = DispatchAreaFactory::random();

        // Act& Assert
        $this->browser()
            ->actingAs(UserFactory::new()->asParticipant()->create()->object())
            ->visit('/data/hospital/new')
            ->assertSuccessful()
            ->assertSeeIn('title', 'Create new Hospital')
            ->fillField('Name', 'Demo Hospital')
            ->fillField('Beds', '123')
            ->fillField('Street', '123 Fake Street')
            ->fillField('Postal code', '12345')
            ->fillField('City', 'Fake City')
            ->fillField('hospital[address][state]', 'Fake State')
            ->fillField('Country', 'Fake Country')
            ->click('Create new Hospital')
            ->assertSuccessful()
            ->assertSee('Success! The Hospital has been created.')
            ->assertSeeIn('div', 'Demo Hospital')
        ;
    }
}

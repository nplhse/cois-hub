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

class HospitalEditControllerTest extends AppWebTestCase
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

        $user = UserFactory::new()->asParticipant()->create();
        $hospital = HospitalFactory::createOne([
            'owner' => $user
        ]);

        // Act& Assert
        $this->browser()
            ->actingAs($user->object())
            ->visit('/data/hospital/'.$hospital->getId().'/edit')
            ->assertSuccessful()
            ->assertSeeIn('title', 'Edit Hospital')
            ->fillField('Name', 'Another Demo Hospital')
            ->fillField('Beds', '123')
            ->fillField('Street', '123 Fake Street')
            ->click('Save changes')
            ->assertSuccessful()
            ->assertSee('Success! The Hospital has been updated.')
            ->assertSeeIn('div', 'Another Demo Hospital')
            ->assertSeeIn('div', '123')
            ->assertSeeIn('div', '123 Fake Street')
        ;
    }
}

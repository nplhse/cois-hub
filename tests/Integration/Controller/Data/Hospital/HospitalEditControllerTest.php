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

    public function testParticipantsCanEditAHospital(): void
    {
        // Arrange
        StateFactory::createOne();
        SupplyAreaFactory::createOne();
        DispatchAreaFactory::createOne();

        $user = UserFactory::new()->asParticipant()->create();
        $hospital = HospitalFactory::createOne([
            'owner' => $user,
        ]);

        // Act& Assert
        $this->browser()
            ->actingAs($user->object())
            ->visit('/data/hospital/'.$hospital->getId().'/edit')
            ->assertSuccessful()
            ->assertSeeIn('title', 'Edit Hospital')
            ->fillField('Name', 'Another Demo Hospital')
            ->click('Save changes')
            ->assertSuccessful()
            ->assertSee('Success! The Hospital has been updated.')
            ->assertSeeIn('div', 'Another Demo Hospital')
        ;
    }

    public function testParticipantsCanEditAHospitalProperties(): void
    {
        // Arrange
        StateFactory::createOne();
        SupplyAreaFactory::createOne();
        DispatchAreaFactory::createOne();

        $user = UserFactory::new()->asParticipant()->create();
        $hospital = HospitalFactory::createOne([
            'owner' => $user,
        ]);

        // Act& Assert
        $this->browser()
            ->actingAs($user->object())
            ->visit('/data/hospital/'.$hospital->getId().'/edit/properties')
            ->assertSuccessful()
            ->fillField('Beds', '123')
            ->click('Save changes')
            ->assertSuccessful()
            ->assertSee('Success! The Hospital has been updated.')
            ->assertSeeIn('div', '123')
        ;
    }

    public function testParticipantsCanEditAHospitalAddress(): void
    {
        // Arrange
        StateFactory::createOne();
        SupplyAreaFactory::createOne();
        DispatchAreaFactory::createOne();

        $user = UserFactory::new()->asParticipant()->create();
        $hospital = HospitalFactory::createOne([
            'owner' => $user,
        ]);

        // Act& Assert
        $this->browser()
            ->actingAs($user->object())
            ->visit('/data/hospital/'.$hospital->getId().'/edit/address')
            ->assertSuccessful()
            ->fillField('Street', '123 Fake Street')
            ->click('Save changes')
            ->assertSuccessful()
            ->assertSee('Success! The Hospital has been updated.')
            ->assertSeeIn('div', '123 Fake Street')
        ;
    }
}

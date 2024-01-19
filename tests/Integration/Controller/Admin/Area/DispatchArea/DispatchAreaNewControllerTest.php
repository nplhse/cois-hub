<?php

namespace App\Tests\Integration\Controller\Admin\Area\DispatchArea;

use App\Factory\DispatchAreaFactory;
use App\Factory\StateFactory;
use App\Factory\SupplyAreaFactory;
use App\Factory\UserFactory;
use App\Tests\AppWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class DispatchAreaNewControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testAdminsCanCreateANewDispatchArea(): void
    {
        // Arrange
        StateFactory::createOne();
        SupplyAreaFactory::createOne();
        DispatchAreaFactory::createOne();

        $state = StateFactory::random();

        // Act& Assert
        $this->browser()
            ->actingAs(UserFactory::new()->asAdmin()->create()->object())
            ->visit('/admin/area/dispatch/new')
            ->assertSuccessful()
            ->assertSeeIn('title', 'New Dispatch Area')
            ->fillField('Name', 'Demo Area')
            ->selectField('State', $state->getName())
            ->click('Create new Dispatch Area')
            ->assertSuccessful()
            ->assertSee('Success! Dispatch Area has been created.')
            ->assertSeeIn('h3', 'Demo Area')
            ->assertSee($state->getName())
        ;
    }
}

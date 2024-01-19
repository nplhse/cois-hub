<?php

namespace App\Tests\Integration\Controller\Admin\Area\SupplyArea;

use App\Factory\DispatchAreaFactory;
use App\Factory\StateFactory;
use App\Factory\SupplyAreaFactory;
use App\Factory\UserFactory;
use App\Tests\AppWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class SupplyAreaEditControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testAdminsCanEditASupplyArea(): void
    {
        // Arrange
        StateFactory::createOne();
        SupplyAreaFactory::createOne();
        DispatchAreaFactory::createOne();

        $supplyArea = SupplyAreaFactory::createOne();

        // Act& Assert
        $this->browser()
            ->actingAs(UserFactory::new()->asAdmin()->create()->object())
            ->visit('/admin/area/supply/'.$supplyArea->getId().'/edit')
            ->assertSuccessful()
            ->assertSeeIn('title', 'Edit Supply Area')
            ->assertSee($supplyArea->getName())
            ->fillField('Name', 'New Area Title')
            ->click('Save changes')
            ->assertSee('Success! The Supply Area has been updated.')
            ->assertSeeIn('h3', 'New Area Title')
        ;
    }
}

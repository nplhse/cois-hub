<?php

namespace App\Tests\Integration\Controller\Admin\Area\SupplyArea;

use App\Factory\DispatchAreaFactory;
use App\Factory\StateFactory;
use App\Factory\SupplyAreaFactory;
use App\Factory\UserFactory;
use App\Tests\AppWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class SupplyAreaListControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testAdminsCanSeeAListOfAllSupplyAreas(): void
    {
        // Arrange
        StateFactory::createOne();
        SupplyAreaFactory::createMany(5);
        DispatchAreaFactory::createOne();

        $randomSupplyArea = SupplyAreaFactory::random();

        // Act& Assert
        $this->browser()
            ->actingAs(UserFactory::new()->asAdmin()->create()->object())
            ->visit('/admin/area/supply')
            ->assertSuccessful()
            ->assertSeeIn('h2', 'Supply Area')
            ->assertSee($randomSupplyArea->getName())
            ->assertSee('Showing 5 results, with 10 per page.')
        ;
    }
}

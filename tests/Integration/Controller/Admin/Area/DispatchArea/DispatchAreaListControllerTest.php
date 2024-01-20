<?php

namespace App\Tests\Integration\Controller\Admin\Area\DispatchArea;

use App\Factory\DispatchAreaFactory;
use App\Factory\StateFactory;
use App\Factory\SupplyAreaFactory;
use App\Factory\UserFactory;
use App\Tests\AppWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class DispatchAreaListControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testAdminsCanSeeAListOfAllDispatchAreas(): void
    {
        // Arrange
        StateFactory::createOne();
        SupplyAreaFactory::createOne();
        DispatchAreaFactory::createMany(5);

        $randomState = StateFactory::random();
        $randomDispatchArea = DispatchAreaFactory::random();

        // Act& Assert
        $this->browser()
            ->actingAs(UserFactory::new()->asAdmin()->create()->object())
            ->visit('/admin/area/dispatch')
            ->assertSuccessful()
            ->assertSeeIn('h2', 'Dispatch Area')
            ->assertSee($randomState->getName())
            ->assertSee($randomDispatchArea->getName())
            ->assertSee('Showing 5 results, with 10 per page.')
        ;
    }
}

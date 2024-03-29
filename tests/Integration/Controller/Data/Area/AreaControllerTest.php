<?php

namespace App\Tests\Integration\Controller\Data\Area;

use App\Factory\DispatchAreaFactory;
use App\Factory\StateFactory;
use App\Factory\SupplyAreaFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class AreaControllerTest extends WebTestCase
{
    use HasBrowser;
    use ResetDatabase;
    use Factories;

    public function testYouCanSeeAllAreas(): void
    {
        // Arrange
        StateFactory::createOne();
        SupplyAreaFactory::createOne();
        DispatchAreaFactory::createMany(15);
        DispatchAreaFactory::createMany(5, [
            'supplyArea' => SupplyAreaFactory::random(),
        ]);

        $randomState = StateFactory::random();
        $randomDispatchArea = DispatchAreaFactory::random();
        $randomSupplyArea = SupplyAreaFactory::random();

        // Act& Assert
        $this->browser()
            ->visit('/data/area/')
            ->assertSuccessful()
            ->assertSeeIn('title', 'List Areas')
            ->assertSee('Showing 20 results, with 20 per page')
            ->assertSee($randomState->getName())
            ->assertSee($randomDispatchArea->getName())
            ->assertSee($randomSupplyArea->getName())
        ;
    }
}

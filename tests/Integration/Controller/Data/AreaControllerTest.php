<?php

namespace App\Tests\Integration\Controller\Data;

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
        StateFactory::createMany(1);
        SupplyAreaFactory::createMany(1);
        DispatchAreaFactory::createMany(20);

        $randomState = StateFactory::random();
        $randomDispatchArea = DispatchAreaFactory::random();
        $randomSupplyArea = SupplyAreaFactory::random();

        $this->browser()
            ->visit('/data/areas')
            ->assertSuccessful()
            ->assertSeeIn('title', 'List Areas')
            ->assertSee('Showing 20 results, with 20 per page')
            ->assertSee($randomState->getName())
            ->assertSee($randomDispatchArea->getName())
            ->assertSee($randomSupplyArea->getName())
        ;
    }
}

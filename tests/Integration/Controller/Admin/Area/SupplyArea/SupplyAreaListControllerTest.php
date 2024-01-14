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
        UserFactory::new(['username' => 'admin'])->asAdmin()->create();

        StateFactory::createOne();
        SupplyAreaFactory::createMany(5);
        DispatchAreaFactory::createOne();

        $randomSupplyArea = SupplyAreaFactory::random();

        $this->browser()
            ->loginAs('admin', 'password')
            ->visit('/admin/area/supply')
            ->assertSuccessful()
            ->assertSeeIn('h2', 'Supply Area')
            ->assertSee($randomSupplyArea->getName())
            ->assertSee('Showing 5 results, with 10 per page.')
        ;
    }
}

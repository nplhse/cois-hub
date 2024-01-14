<?php

namespace App\Tests\Integration\Controller\Admin\Area\SupplyArea;

use App\Factory\DispatchAreaFactory;
use App\Factory\StateFactory;
use App\Factory\SupplyAreaFactory;
use App\Factory\UserFactory;
use App\Tests\AppWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class SupplyAreaShowControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testAdminsCanViewSupplyAreas(): void
    {
        UserFactory::new(['username' => 'admin'])->asAdmin()->create();

        StateFactory::createOne();
        SupplyAreaFactory::createOne();
        DispatchAreaFactory::createOne();

        $supplyArea = SupplyAreaFactory::random();

        $this->browser()
            ->loginAs('admin', 'password')
            ->visit('/admin/area/supply/'.$supplyArea->getId())
            ->assertSuccessful()
            ->assertSeeIn('h2', 'Supply Area')
            ->assertSeeIn('h3', $supplyArea->getName())
        ;
    }
}

<?php

namespace App\Tests\Integration\Controller\Admin\Area\SupplyArea;

use App\Factory\DispatchAreaFactory;
use App\Factory\StateFactory;
use App\Factory\UserFactory;
use App\Tests\AppWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class SupplyAreaNewControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testAdminsCanCreateANewSupplyArea(): void
    {
        UserFactory::new(['username' => 'admin'])->asAdmin()->create();

        StateFactory::createOne();
        DispatchAreaFactory::createOne();

        $this->browser()
            ->loginAs('admin', 'password')
            ->visit('/admin/area/supply/new')
            ->assertSuccessful()
            ->assertSeeIn('title', 'New Supply Area')
            ->fillField('Name', 'Demo Area')
            ->click('Create Supply Area')
            ->assertSuccessful()
            ->assertSee('Success! Supply Area has been created.')
            ->assertSeeIn('h3', 'Demo Area')
        ;
    }
}

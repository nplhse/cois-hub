<?php

namespace App\Tests\Integration\Controller\Admin\Area\DispatchArea;

use App\Factory\DispatchAreaFactory;
use App\Factory\StateFactory;
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
        UserFactory::new(['username' => 'admin'])->asAdmin()->create();

        $state = StateFactory::createOne();
        DispatchAreaFactory::createOne();

        $this->browser()
            ->loginAs('admin', 'password')
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

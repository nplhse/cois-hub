<?php

namespace App\Tests\Integration\Controller\Admin\Area\State;

use App\Factory\UserFactory;
use App\Tests\AppWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class StateNewControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testAdminsCanCreateANewState(): void
    {
        UserFactory::new(['username' => 'admin'])->asAdmin()->create();

        $this->browser()
            ->loginAs('admin', 'password')
            ->visit('/admin/area/state/new')
            ->assertSuccessful()
            ->assertSeeIn('title', 'Create new State')
            ->fillField('Name', 'Demo State')
            ->click('Create State')
            ->assertSuccessful()
            ->assertSee('Success! The State has been created.')
            ->assertSeeIn('h3', 'Demo State')
        ;
    }
}

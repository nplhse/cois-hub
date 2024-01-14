<?php

namespace App\Tests\Integration\Controller\Admin\Area\State;

use App\Factory\StateFactory;
use App\Factory\UserFactory;
use App\Tests\AppWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class StateEditControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testAdminsCanEditAState(): void
    {
        UserFactory::new(['username' => 'admin'])->asAdmin()->create();

        $state = StateFactory::createOne();

        $this->browser()
            ->loginAs('admin', 'password')
            ->visit('/admin/area/state/'.$state->getId().'/edit')
            ->assertSuccessful()
            ->assertSeeIn('title', 'Edit State')
            ->fillField('Name', 'Another Demo State')
            ->click('Save changes')
            ->assertSuccessful()
            ->assertSee('Success! State has been updated.')
            ->assertSeeIn('h3', 'Another Demo State')
        ;
    }
}

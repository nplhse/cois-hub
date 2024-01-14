<?php

namespace App\Tests\Integration\Controller\Admin\Area\State;

use App\Factory\StateFactory;
use App\Factory\UserFactory;
use App\Tests\AppWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class StateShowControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testAdminsCanViewStates(): void
    {
        UserFactory::new(['username' => 'admin'])->asAdmin()->create();

        $state = StateFactory::createOne();

        $this->browser()
            ->loginAs('admin', 'password')
            ->visit('/admin/area/state/'.$state->getId())
            ->assertSuccessful()
            ->assertSeeIn('h2', 'State')
            ->assertSeeIn('h3', $state->getName())
        ;
    }
}

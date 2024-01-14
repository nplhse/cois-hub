<?php

namespace App\Tests\Integration\Controller\Admin\Area\State;

use App\Factory\StateFactory;
use App\Factory\UserFactory;
use App\Tests\AppWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class StateListControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testAdminsCanSeeAListOfAllStates(): void
    {
        UserFactory::new(['username' => 'admin'])->asAdmin()->create();

        StateFactory::createMany(5);

        $randomState = StateFactory::random();

        $this->browser()
            ->loginAs('admin', 'password')
            ->visit('/admin/area/state')
            ->assertSuccessful()
            ->assertSeeIn('h2', 'State')
            ->assertSee($randomState->getName())
            ->assertSee('Showing 5 results, with 10 per page.')
        ;
    }
}

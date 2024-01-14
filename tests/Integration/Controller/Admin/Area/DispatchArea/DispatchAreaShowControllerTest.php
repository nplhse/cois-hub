<?php

namespace App\Tests\Integration\Controller\Admin\Area\DispatchArea;

use App\Factory\DispatchAreaFactory;
use App\Factory\StateFactory;
use App\Factory\UserFactory;
use App\Tests\AppWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class DispatchAreaShowControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testAdminsCanViewDispatchAreas(): void
    {
        UserFactory::new(['username' => 'admin'])->asAdmin()->create();

        StateFactory::createOne();

        $dispatchArea = DispatchAreaFactory::createOne();

        $this->browser()
            ->loginAs('admin', 'password')
            ->visit('/admin/area/dispatch/'.$dispatchArea->getId())
            ->assertSuccessful()
            ->assertSeeIn('h2', 'Dispatch Area')
            ->assertSeeIn('h3', $dispatchArea->getName())
            ->assertSee($dispatchArea->getState()->getName())
        ;
    }
}

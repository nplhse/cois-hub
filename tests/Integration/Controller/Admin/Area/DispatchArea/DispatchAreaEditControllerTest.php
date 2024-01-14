<?php

namespace App\Tests\Integration\Controller\Admin\Area\DispatchArea;

use App\Factory\DispatchAreaFactory;
use App\Factory\StateFactory;
use App\Factory\UserFactory;
use App\Tests\AppWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class DispatchAreaEditControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testAdminsCanEditADispatchArea(): void
    {
        UserFactory::new(['username' => 'admin'])->asAdmin()->create();
        StateFactory::createOne();

        $dispatchArea = DispatchAreaFactory::createOne();

        $this->browser()
            ->loginAs('admin', 'password')
            ->visit('/admin/area/dispatch/'.$dispatchArea->getId().'/edit')
            ->assertSuccessful()
            ->assertSeeIn('title', 'Edit Dispatch Area')
            ->fillField('Name', 'New Area Title')
            ->click('Save changes')
            ->assertSuccessful()
            ->assertSee('Success! Dispatch Area has been updated.')
            ->assertSeeIn('h3', 'New Area Title')
        ;
    }
}

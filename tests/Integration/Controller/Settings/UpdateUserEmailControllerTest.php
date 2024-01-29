<?php

namespace App\Tests\Integration\Controller\Settings;

use App\Factory\UserFactory;
use App\Tests\AppWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class UpdateUserEmailControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testUsersCanChangeEmailAddress(): void
    {
        $user = UserFactory::new()->create();

        // Act& Assert
        $this->browser()
            ->actingAs($user->object())
            ->visit('/settings/email')
            ->assertSuccessful()
            ->assertSeeIn('title', 'Set a new E-Mail address')
            ->fillField('Email', 'test@test.dev')
            ->click('Change E-Mail Address')
            ->assertSuccessful()
            ->assertSee('Success! Your E-Mail address has been updated!')
            ->assertSee('test@test.dev')
            ->assertSee('Address is not verified')
        ;
    }
}

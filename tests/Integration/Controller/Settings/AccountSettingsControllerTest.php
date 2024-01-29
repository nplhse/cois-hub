<?php

namespace App\Tests\Integration\Controller\Settings;

use App\Factory\UserFactory;
use App\Tests\AppWebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class AccountSettingsControllerTest extends AppWebTestCase
{
    use ResetDatabase;
    use Factories;

    public function testUsersCanAccessSettings(): void
    {
        // Act& Assert
        $this->browser()
            ->actingAs(UserFactory::new()->create()->object())
            ->visit('/settings')
            ->assertSuccessful()
            ->assertSeeIn('title', 'My Account')
            ->assertSeeIn('div', 'Username')
            ->assertSeeIn('div', 'E-Mail address')
            ->assertSeeIn('div', 'Password')
            ->assertSeeIn('div', 'Public profile')
        ;
    }
}

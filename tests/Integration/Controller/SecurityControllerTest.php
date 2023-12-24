<?php

declare(strict_types=1);

namespace App\Tests\Integration\Controller;

use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class SecurityControllerTest extends WebTestCase
{
    use HasBrowser;
    use ResetDatabase;
    use Factories;

    public function testYouCanLoginAndLogout(): void
    {
        UserFactory::new(['username' => 'foo'])->create();

        $this->browser()
            ->visit('/login')
            ->assertSeeIn('title', 'Login')
            ->assertSeeIn('h2', 'Login')
            ->fillField('Username', 'foo')
            ->fillField('Password', 'password')
            ->click('Sign in')
            ->assertSuccessful()
            ->assertSeeIn('#user_name', 'foo')
            ->assertNotSee('Login')
            ->visit('/logout')
            ->assertNotSee('foo')
        ;
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Integration\Controller\Security;

use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class RegisterControllerTest extends WebTestCase
{
    use HasBrowser;
    use ResetDatabase;
    use Factories;

    public function testYouCanRegister(): void
    {
        // Act& Assert
        $this->browser()
            ->visit('/register')
            ->assertSeeIn('title', 'Create new account')
            ->assertSeeIn('h2', 'Create new account')
            ->fillField('Username', 'foo')
            ->fillField('Email', 'foo@bar.com')
            ->fillField('Password', 'password')
            ->fillField('Repeat Password', 'password')
            ->checkField('Agree terms')
            ->click('Create new account')
            ->assertSuccessful()
            ->assertSeeIn('#user_name', 'foo')
            ->assertSee("Thank you for registering an account, we've emailed you a link to verify your E-Mail address.")
            ->assertNotSee('Login')
        ;
    }
}

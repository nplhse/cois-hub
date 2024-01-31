<?php

namespace App\Tests\Integration\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CookieConsentControllerTest extends WebTestCase
{
    use HasBrowser;
    use ResetDatabase;
    use Factories;

    public function testYouCanAcceptEssentialCookies(): void
    {
        // Act& Assert
        $this->browser()
            ->visit('/')
            ->assertSee('What do you think about Cookies?')
            ->click('Essential Cookies Only')
            ->assertSuccessful()
            ->assertNotSee('What do you think about Cookies?')
        ;
    }

    public function testYouCanAcceptAllCookies(): void
    {
        // Act& Assert
        $this->browser()
            ->visit('/')
            ->assertSee('What do you think about Cookies?')
            ->click('Allow All Cookies')
            ->assertSuccessful()
            ->assertNotSee('What do you think about Cookies?')
        ;
    }

    public function testYouHaveToAcceptCookies(): void
    {
        // Act& Assert
        $this->browser()
            ->visit('/')
            ->assertSee('What do you think about Cookies?')
            ->click('Login')
            ->assertSuccessful()
            ->assertSee('What do you think about Cookies?')
        ;
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\ResetDatabase;

class AppRoutesTest extends WebTestCase
{
    use ResetDatabase;

    /**
     * @dataProvider getPublicUrls
     */
    public function testPublicUrlsAreReachable(string $url): void
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider getSecureUrls
     */
    public function testSecureUrlsAreRestricted(string $url): void
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertResponseRedirects(
            '/login',
            Response::HTTP_FOUND
        );
    }

    public function testLogoutUrlRedirects(): void
    {
        $client = static::createClient();

        $client->request('GET', '/logout');
        $this->assertResponseRedirects(
            '/',
            Response::HTTP_FOUND
        );
    }

    public function getPublicUrls(): ?\Generator
    {
        yield 'app_homepage' => ['/'];
        yield 'app_login' => ['/login'];
        yield 'app_register' => ['/register'];
        yield 'app_forgot_password_request' => ['/reset-password'];
        yield 'app_check_email' => ['reset-password/check-email'];
        yield 'app_user' => ['/user/'];
    }

    public function getSecureUrls(): ?\Generator
    {
        yield 'app_admin_dashboard' => ['/admin/'];
        yield 'app_settings' => ['/settings'];
        yield 'app_settings_password' => ['/settings/password'];
    }
}

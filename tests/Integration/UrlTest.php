<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\ResetDatabase;

class UrlTest extends WebTestCase
{
    use ResetDatabase;

    /**
     * @dataProvider getPublicUrls
     */
    public function testPublicUrls(string $url): void
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider getSecureUrls
     */
    public function testSecureUrls(string $url): void
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertResponseRedirects(
            '/login',
            Response::HTTP_FOUND
        );
    }

    public function getPublicUrls(): ?\Generator
    {
        yield 'app_homepage' => ['/'];
        yield 'app_login' => ['/login'];
        yield 'app_register' => ['/register'];
    }

    public function getSecureUrls(): ?\Generator
    {
        yield 'app_admin_dashboard' => ['/admin/'];
        yield 'app_settings' => ['/settings'];
    }
}

<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

/**
 * @method AppBrowser browser()
 */
abstract class AppWebTestCase extends WebTestCase
{
    use HasBrowser;
}

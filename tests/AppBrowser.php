<?php

namespace App\Tests;

use App\Tests\Browser\AuthenticationExtension;
use Zenstruck\Browser\KernelBrowser;

class AppBrowser extends KernelBrowser
{
    use AuthenticationExtension;
}

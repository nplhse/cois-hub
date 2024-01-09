<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Twig\Runtime\DiffExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DiffExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_diff', [DiffExtensionRuntime::class, 'getDiff'], ['is_safe' => ['html']]),
        ];
    }
}

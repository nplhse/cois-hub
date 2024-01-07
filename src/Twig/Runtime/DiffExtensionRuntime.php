<?php

declare(strict_types=1);

namespace App\Twig\Runtime;

use SebastianBergmann\Diff\Differ;
use Twig\Extension\RuntimeExtensionInterface;

class DiffExtensionRuntime implements RuntimeExtensionInterface
{
    private readonly Differ $differ;

    public function __construct()
    {
        $this->differ = new Differ();
    }

    public function getDiff(mixed $before, mixed $after): string
    {
        return $this->differ->diff($before, $after);
    }
}

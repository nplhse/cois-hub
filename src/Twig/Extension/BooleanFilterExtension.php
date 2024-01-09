<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class BooleanFilterExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('boolean', $this->booleanFilter(...)),
        ];
    }

    public function booleanFilter(bool $value): string
    {
        if (is_bool($value)) {
            if ($value) {
                return 'true';
            }

            return 'false';
        }

        return $value;
    }

    public function getName(): string
    {
        return 'boolean_filter';
    }
}

<?php

declare(strict_types=1);

namespace App\Enum;

enum ImportType: string
{
    case ALLOCATION = 'Allocation';

    public function getType(): string
    {
        return match ($this) {
            self::ALLOCATION => self::ALLOCATION->value,
        };
    }

    /**
     * @return string[]
     */
    public static function getValues(): array
    {
        return [
            self::ALLOCATION->value,
        ];
    }
}

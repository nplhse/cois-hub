<?php

declare(strict_types=1);

namespace App\Enum;

enum HospitalLocation: string
{
    case URBAN = 'Urban';
    case RURAL = 'Rural';

    public function getType(): string
    {
        return match ($this) {
            self::URBAN => self::URBAN->value,
            self::RURAL => self::RURAL->value,
        };
    }

    /**
     * @return string[]
     */
    public static function getValues(): array
    {
        return [
            self::URBAN->value,
            self::RURAL->value,
        ];
    }
}

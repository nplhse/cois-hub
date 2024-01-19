<?php

declare(strict_types=1);

namespace App\Enum;

enum HospitalTier: string
{
    case BASIC = 'Basic';
    case EXTENDED = 'Extended';
    case FULL = 'Full';

    public function getType(): string
    {
        return match ($this) {
            self::BASIC => self::BASIC->value,
            self::EXTENDED => self::EXTENDED->value,
            self::FULL => self::FULL->value,
        };
    }

    /**
     * @return string[]
     */
    public static function getValues(): array
    {
        return [
            self::BASIC->value,
            self::EXTENDED->value,
            self::FULL->value,
        ];
    }
}

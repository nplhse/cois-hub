<?php

declare(strict_types=1);

namespace App\Enum;

enum HospitalSize: string
{
    case SMALL = 'Small';
    case MEDIUM = 'Medium';
    case LARGE = 'Large';

    public function getType(): string
    {
        return match ($this) {
            self::SMALL => self::SMALL->value,
            self::MEDIUM => self::MEDIUM->value,
            self::LARGE => self::LARGE->value,
        };
    }

    /**
     * @return string[]
     */
    public static function getValues(): array
    {
        return [
            self::SMALL->value,
            self::MEDIUM->value,
            self::LARGE->value,
        ];
    }
}

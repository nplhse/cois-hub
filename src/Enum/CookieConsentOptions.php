<?php

namespace App\Enum;

enum CookieConsentOptions: string
{
    case ESSENTIAL = 'essential';

    public function getType(): string
    {
        return match ($this) {
            default => self::ESSENTIAL->value,
        };
    }

    /**
     * @return array <array-key, string>
     */
    public static function getAll(): array
    {
        return [
            self::ESSENTIAL->value,
        ];
    }
}

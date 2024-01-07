<?php

namespace App\Enum;

enum CookieConsentOptions: string
{
    case ALL = 'all';
    case ESSENTIAL = 'essential';

    public function getType(): string
    {
        return match ($this) {
            self::ALL => self::ALL->value,
            default => self::ESSENTIAL->value,
        };
    }
}

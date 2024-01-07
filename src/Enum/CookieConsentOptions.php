<?php

namespace App\Enum;

enum CookieConsentOptions: string
{
    case ESSENTIAL = 'essential';

    public function getType(): string
    {
        return match ($this) {
            self::ESSENTIAL => self::ESSENTIAL->value,
        };
    }
}

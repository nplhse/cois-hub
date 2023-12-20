<?php

namespace App\Enum;

enum AuditActions: string
{
    case INSERT = 'insert';
    case UPDATE = 'update';
    case REMOVE = 'remove';

    public function getType(): string
    {
        return match ($this) {
            self::INSERT => self::INSERT->value,
            self::UPDATE => self::UPDATE->value,
            self::REMOVE => self::REMOVE->value
        };
    }
}

<?php

declare(strict_types=1);

namespace App\Enum;

enum ImportStatus: string
{
    case CREATED = 'Created';
    case PROCESSING = 'Processing';
    case SUCCESS = 'Success';
    case INCOMPLETE = 'Incomplete';
    case FAILURE = 'Failure';

    public function getType(): string
    {
        return match ($this) {
            self::CREATED => self::CREATED->value,
            self::PROCESSING => self::PROCESSING->value,
            self::SUCCESS => self::SUCCESS->value,
            self::INCOMPLETE => self::INCOMPLETE->value,
            self::FAILURE => self::FAILURE->value,
        };
    }

    /**
     * @return string[]
     */
    public static function getValues(): array
    {
        return [
            self::CREATED->value,
            self::PROCESSING->value,
            self::SUCCESS->value,
            self::INCOMPLETE->value,
            self::FAILURE->value,
        ];
    }
}

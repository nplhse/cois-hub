<?php

declare(strict_types=1);

namespace App\Event;

trait NamedEvent
{
    public function getName(): string
    {
        return self::NAME;
    }
}

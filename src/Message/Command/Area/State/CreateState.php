<?php

namespace App\Message\Command\Area\State;

final readonly class CreateState
{
    public function __construct(
        private string $name,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }
}

<?php

namespace App\Command\Area;

final readonly class CreateStateCommand
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

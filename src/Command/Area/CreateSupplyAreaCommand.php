<?php

namespace App\Command\Area;

final readonly class CreateSupplyAreaCommand
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

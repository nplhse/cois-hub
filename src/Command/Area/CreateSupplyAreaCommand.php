<?php

namespace App\Command\Area;

use App\Entity\DispatchArea;

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

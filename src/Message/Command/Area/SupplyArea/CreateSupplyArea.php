<?php

namespace App\Message\Command\Area\SupplyArea;

final readonly class CreateSupplyArea
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

<?php

namespace App\Message\Command\Area\DispatchArea;

use App\Entity\State;
use App\Entity\SupplyArea;

final readonly class UpdateDispatchArea
{
    public function __construct(
        private int $id,
        private string $name,
        private State $state,
        private ?SupplyArea $supplyArea
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getState(): State
    {
        return $this->state;
    }

    public function getSupplyArea(): ?SupplyArea
    {
        return $this->supplyArea;
    }
}

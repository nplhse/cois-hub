<?php

namespace App\Message\Command\Area\SupplyArea;

final readonly class DeleteSupplyArea
{
    public function __construct(
        private int $id
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }
}

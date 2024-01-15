<?php

namespace App\Message\Command\Area\State;

final readonly class DeleteState
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

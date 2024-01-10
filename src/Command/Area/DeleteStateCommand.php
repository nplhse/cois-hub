<?php

namespace App\Command\Area;

final readonly class DeleteStateCommand
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

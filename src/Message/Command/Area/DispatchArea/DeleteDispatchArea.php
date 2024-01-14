<?php

namespace App\Message\Command\Area\DispatchArea;

final readonly class DeleteDispatchArea
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

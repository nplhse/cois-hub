<?php

declare(strict_types=1);

namespace App\Message\Event\Hospital;

final readonly class HospitalDeleted
{
    public function __construct(
        private readonly int $hospitalId,
        private readonly string $name,
    ) {
    }

    public function getHospitalId(): int
    {
        return $this->hospitalId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

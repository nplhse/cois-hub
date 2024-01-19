<?php

declare(strict_types=1);

namespace App\Message\Event\Hospital;

final readonly class HospitalCreated
{
    public function __construct(
        private readonly int $hospitalId,
    ) {
    }

    public function getHospitalId(): int
    {
        return $this->hospitalId;
    }
}

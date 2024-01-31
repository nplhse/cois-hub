<?php

namespace App\Message\Command\Hospital;

final readonly class UpdateHospitalAssociatedUsers
{
    public function __construct(
        private int $hospitalId,
        private array $associatedUsers
    ) {
    }

    public function getHospitalId(): int
    {
        return $this->hospitalId;
    }

    public function getAssociatedUsers(): array
    {
        return $this->associatedUsers;
    }
}

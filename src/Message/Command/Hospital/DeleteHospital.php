<?php

namespace App\Message\Command\Hospital;

final readonly class DeleteHospital
{
    public function __construct(
        private int $hospitalId
    ) {
    }

    public function getHospitalId(): int
    {
        return $this->hospitalId;
    }
}

<?php

namespace App\Twig\Components;

use App\Query\HospitalCountQuery;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final readonly class HospitalCountWidget
{
    public function __construct(
        private HospitalCountQuery $query,
    ) {
    }

    public function getAllHospitals(): ?int
    {
        return (int) $this->query->countAllHospitals();
    }
}

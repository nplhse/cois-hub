<?php

namespace App\Query;

use App\Entity\Hospital;
use Doctrine\ORM\EntityManagerInterface;

class HospitalCountQuery
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function countAllHospitals(): ?int
    {
        $qb = $this->entityManager->createQueryBuilder()->from(Hospital::class, 'h');
        $qb->select($qb->expr()->count('h.id'));

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}

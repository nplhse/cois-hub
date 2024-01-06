<?php

namespace App\Query;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserCountQuery
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function countAllUsers(): ?int
    {
        $qb = $this->entityManager->createQueryBuilder()->from(User::class, 'u');
        $qb->select($qb->expr()->count('u.id'));

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}

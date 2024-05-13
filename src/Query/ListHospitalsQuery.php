<?php

namespace App\Query;

use App\Entity\DispatchArea;
use App\Entity\Hospital;
use App\Entity\State;
use App\Pagination\Paginator;
use Doctrine\ORM\EntityManagerInterface;

class ListHospitalsQuery
{
    /**
     * @var array|string[]
     */
    public static array $validSorts = ['id', 'name', 'createdAt', 'updatedAt'];

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function getResults(int $page = 1, int $perPage = 20, string $sortBy = 'name', string $orderBy = 'asc', string $search = ''): Paginator
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('h.id, h.name, h.createdAt, h.updatedAt, s.id as state_id, s.name as state, da.id as dispatchArea_id, da.name as dispatchArea')
            ->from(Hospital::class, 'h')
            ->leftJoin(
                State::class,
                's',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'h.state = s.id'
            )
            ->leftJoin(
                DispatchArea::class,
                'da',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'h.dispatchArea = da.id'
            );

        $sortBy = $this->filterSortBy($sortBy) ? $sortBy : 'name';
        $orderBy = $this->filterOrderBy($orderBy);

        $qb->orderBy('h.'.$sortBy, $orderBy);

        if ('' !== $search && '0' !== $search) {
            $qb->andWhere($qb->expr()->like('h.name', ':search'))
                ->setParameter('search', '%'.$search.'%');
        }

        return (new Paginator($qb))->paginate($page, $perPage);
    }

    public function countResults(string $sortBy = 'name', string $search = ''): ?int
    {
        $qb = $this->entityManager->createQueryBuilder()->from(Hospital::class, 'h');

        $sortBy = $this->filterSortBy($sortBy) ? $sortBy : 'name';

        $qb->select($qb->expr()->count('h.id'));

        if ('' !== $search && '0' !== $search) {
            $qb->andWhere($qb->expr()->like('h.'.$sortBy, ':search'))
                ->setParameter('search', '%'.$search.'%');
        }

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    private function filterSortBy(string $sortBy): bool
    {
        return in_array($sortBy, self::$validSorts, true);
    }

    private function filterOrderBy(string $orderBy): string
    {
        return match ($orderBy) {
            'desc' => 'DESC',
            default => 'ASC',
        };
    }
}

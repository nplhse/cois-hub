<?php

namespace App\Query;

use App\Entity\State;
use App\Pagination\Paginator;
use Doctrine\ORM\EntityManagerInterface;

class AreaStateListQuery
{
    /**
     * @var array|string[]
     */
    public static array $validSorts = ['id', 'name', 'createdAt', 'updatedAt'];

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function getResults(int $page = 1, int $perPage = 10, string $sortBy = 'name', string $orderBy = 'asc', string $search = ''): Paginator
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('s.id, s.name, s.createdAt, s.updatedAt')
            ->from(State::class, 's');

        $sortBy = $this->filterSortBy($sortBy) ? $sortBy : 'name';
        $orderBy = $this->filterOrderBy($orderBy);

        $qb->orderBy('s.'.$sortBy, $orderBy);

        if (!empty($search)) {
            $qb->andWhere($qb->expr()->like('s.name', ':search'))
                ->setParameter('search', '%'.$search.'%');
        }

        return (new Paginator($qb))->paginate($page, $perPage);
    }

    public function countResults(string $sortBy = 'name', string $search = ''): ?int
    {
        $qb = $this->entityManager->createQueryBuilder()->from(State::class, 's');

        $sortBy = $this->filterSortBy($sortBy) ? $sortBy : 'name';

        $qb->select($qb->expr()->count('s.id'));

        if (!empty($search)) {
            $qb->andWhere($qb->expr()->like('s.'.$sortBy, ':search'))
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

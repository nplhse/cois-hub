<?php

namespace App\Query;

use App\Entity\DispatchArea;
use App\Entity\State;
use App\Pagination\Paginator;
use Doctrine\ORM\EntityManagerInterface;

class AreaDispatchListQuery
{
    /**
     * @var array|string[]
     */
    public static array $validSorts = ['id', 'name', 'state', 'createdAt', 'updatedAt'];

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function getResults(int $page = 1, int $perPage = 10, string $sortBy = 'name', string $orderBy = 'asc', string $search = ''): Paginator
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('da.id, da.name, da.createdAt, da.updatedAt, s.id as state_id, s.name as state')
            ->from(DispatchArea::class, 'da')
            ->leftJoin(
                State::class,
                's',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'da.state = s.id'
            );

        $sortBy = $this->filterSortBy($sortBy) ? $sortBy : 'name';
        $orderBy = $this->filterOrderBy($orderBy);

        $qb->orderBy('da.'.$sortBy, $orderBy);

        if ('' !== $search && '0' !== $search) {
            $qb->andWhere($qb->expr()->like('da.name', ':search'))
                ->setParameter('search', '%'.$search.'%');
        }

        return (new Paginator($qb))->paginate($page, $perPage);
    }

    public function countResults(string $sortBy = 'name', string $search = ''): ?int
    {
        $qb = $this->entityManager->createQueryBuilder()->from(DispatchArea::class, 'da');

        $sortBy = $this->filterSortBy($sortBy) ? $sortBy : 'name';

        $qb->select($qb->expr()->count('da.id'));

        if ('' !== $search && '0' !== $search) {
            $qb->andWhere($qb->expr()->like('da.'.$sortBy, ':search'))
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

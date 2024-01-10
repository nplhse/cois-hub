<?php

namespace App\Query;

use App\Entity\DispatchArea;
use App\Entity\SupplyArea;
use App\Pagination\Paginator;
use Doctrine\ORM\EntityManagerInterface;

class AreaSupplyListQuery
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
        $qb->select('sa.id, sa.name, sa.createdAt, sa.updatedAt, COUNT(da.id) as dispatch_areas')
            ->from(SupplyArea::class, 'sa')
            ->groupBy('sa')
            ->leftJoin(
                DispatchArea::class,
                'da',
                \Doctrine\ORM\Query\Expr\Join::WITH,
                'da.supplyArea = sa.id'
            );

        $sortBy = $this->filterSortBy($sortBy) ? $sortBy : 'name';
        $orderBy = $this->filterOrderBy($orderBy);

        $qb->orderBy('sa.'.$sortBy, $orderBy);

        if (!empty($search)) {
            $qb->andWhere($qb->expr()->like('sa.name', ':search'))
                ->setParameter('search', '%'.$search.'%');
        }

        return (new Paginator($qb))->paginate($page, $perPage);
    }

    public function countResults(string $sortBy = 'name', string $search = ''): ?int
    {
        $qb = $this->entityManager->createQueryBuilder()->from(SupplyArea::class, 'sa');

        $sortBy = $this->filterSortBy($sortBy) ? $sortBy : 'name';

        $qb->select($qb->expr()->count('sa.id'));

        if (!empty($search)) {
            $qb->andWhere($qb->expr()->like('sa.'.$sortBy, ':search'))
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

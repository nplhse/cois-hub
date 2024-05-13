<?php

namespace App\Query;

use App\Entity\User;
use App\Pagination\Paginator;
use Doctrine\ORM\EntityManagerInterface;

class UserListQuery
{
    /**
     * @var array|string[]
     */
    public static array $validSorts = ['id', 'createdAt', 'updatedAt', 'username'];

    private bool $isPublic = false;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function onlyPublicUsers(): self
    {
        $this->isPublic = true;

        return $this;
    }

    public function getResults(int $page = 1, int $perPage = 10, string $sortBy = 'username', string $orderBy = 'asc', string $search = ''): Paginator
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('u.id, u.username, u.email, u.roles, u.createdAt, u.updatedAt, u.isVerified, u.hasCredentialsExpired')
            ->from(User::class, 'u');

        $sortBy = $this->filterSortBy($sortBy) ? $sortBy : 'username';
        $orderBy = $this->filterOrderBy($orderBy);

        $qb->orderBy('u.'.$sortBy, $orderBy);

        if ('' !== $search && '0' !== $search) {
            $qb->andWhere($qb->expr()->like('u.username', ':search'))
                ->orWhere($qb->expr()->like('u.email', ':search'))
                ->setParameter('search', '%'.$search.'%');
        }

        if ($this->isPublic) {
            $qb->andWhere($qb->expr()->eq('u.isPublic', true));
        }

        return (new Paginator($qb))->paginate($page, $perPage);
    }

    public function countResults(string $sortBy = 'username', string $search = ''): ?int
    {
        $qb = $this->entityManager->createQueryBuilder()->from(User::class, 'u');

        $sortBy = $this->filterSortBy($sortBy) ? $sortBy : 'username';

        $qb->select($qb->expr()->count('u.id'));

        if ('' !== $search && '0' !== $search) {
            $qb->andWhere($qb->expr()->like('u.'.$sortBy, ':search'))
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

<?php

namespace App\Repository;

use App\Entity\User;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    /**
     * @var array|string[]
     */
    public static array $validSorts = ['id', 'createdAt', 'updatedAt', 'username'];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function add(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function saveAndFlush(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function getUserCount(string $sortBy = 'username', string $orderBy = 'asc', string $search = ''): int
    {
        $query = $this->createQueryBuilder('u');
        $query->select($query->expr()->count('u.id'));

        if (!empty($search)) {
            $query->andWhere($query->expr()->like('u.'.$sortBy, ':search'))
                ->setParameter('search', '%'.$search.'%');
        }

        return $query->getQuery()->getSingleScalarResult();
    }

    public function getPublicUserCount(string $sortBy = 'username', string $orderBy = 'asc', string $search = ''): int
    {
        $sortBy = $this->filterSortBy($sortBy) ? $sortBy : 'username';
        $orderBy = $this->filterOrderBy($orderBy);

        $query = $this->createQueryBuilder('u');
        $query->select($query->expr()->count('u.id'))
            ->andWhere($query->expr()->eq('u.isPublic', true));

        if (!empty($search)) {
            $query->andWhere($query->expr()->like('u.'.$sortBy, ':search'))
                ->setParameter('search', '%'.$search.'%');
        }

        return $query->getQuery()->getSingleScalarResult();
    }

    public function getPaginatedResults(int $page = 1, int $perPage = 10, string $sortBy = 'username', string $orderBy = 'asc', string $search = ''): Paginator
    {
        $sortBy = $this->filterSortBy($sortBy) ? $sortBy : 'username';
        $orderBy = $this->filterOrderBy($orderBy);

        $query = $this->createQueryBuilder('u')
            ->orderBy('u.'.$sortBy, $orderBy)
        ;

        if (!empty($search)) {
            $query->andWhere($query->expr()->like('u.'.$sortBy, ':search'))
                ->setParameter('search', '%'.$search.'%');
        }

        return (new Paginator($query))->paginate($page, $perPage);
    }

    public function getPublicPaginatedResults(int $page = 1, int $perPage = 10, string $sortBy = 'username', string $orderBy = 'asc', string $search = ''): Paginator
    {
        $sortBy = $this->filterSortBy($sortBy) ? $sortBy : 'username';
        $orderBy = $this->filterOrderBy($orderBy);

        $query = $this->createQueryBuilder('u')
            ->orderBy('u.'.$sortBy, $orderBy);

        $query->andWhere($query->expr()->eq('u.isPublic', true));

        if (!empty($search)) {
            $query->andWhere($query->expr()->like('u.'.$sortBy, ':search'))
                ->setParameter('search', '%'.$search.'%');
        }

        return (new Paginator($query))->paginate($page, $perPage);
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

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

    public function getUserCount(bool $isPublic = false): int
    {
        $query = $this->createQueryBuilder('u')
            ->select('count(u.id)');

        if (true === $isPublic) {
            $query
                ->andWhere('u.isPublic = :is_public')
                ->setParameter('is_public', $isPublic);
        }

        return $query->getQuery()->getSingleScalarResult();
    }

    public function getPaginatedResults(int $page = 1, int $perPage = 10, string $sortBy = 'username', string $orderBy = 'asc'): Paginator
    {
        $sortBy = in_array($sortBy, self::$validSorts, true) ? $sortBy : 'username';
        $orderBy = match ($orderBy) {
            'desc' => 'DESC',
            default => 'ASC',
        };

        $query = $this->createQueryBuilder('u')
            ->orderBy('u.'.$sortBy, $orderBy)
        ;

        return (new Paginator($query))->paginate($page, $perPage);
    }

    public function getPublicPaginatedResults(int $page = 1, int $perPage = 10, string $sortBy = 'username', string $orderBy = 'asc'): Paginator
    {
        $sortBy = in_array($sortBy, self::$validSorts, true) ? $sortBy : 'username';
        $orderBy = match ($orderBy) {
            'desc' => 'DESC',
            default => 'ASC',
        };

        $query = $this->createQueryBuilder('u')
            ->where('u.isPublic = true')
            ->orderBy('u.'.$sortBy, $orderBy)
        ;

        return (new Paginator($query))->paginate($page, $perPage);
    }
}

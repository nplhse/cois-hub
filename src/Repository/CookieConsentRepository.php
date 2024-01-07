<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CookieConsent;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CookieConsent|null find($id, $lockMode = null, $lockVersion = null)
 * @method CookieConsent|null findOneBy(array $criteria, array $orderBy = null)
 * @method CookieConsent[]    findAll()
 * @method CookieConsent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CookieConsentRepository extends ServiceEntityRepository
{
    final public const PER_PAGE = 25;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CookieConsent::class);
    }

    public function add(CookieConsent $entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    public function remove(CookieConsent $entity): void
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }

    public function getPaginatedResults(int $page = 1, int $perPage = self::PER_PAGE): Paginator
    {
        $query = $this->createQueryBuilder('cc')
            ->orderBy('cc.createdAt', 'DESC');

        return (new Paginator($query))->paginate($page, $perPage);
    }
}

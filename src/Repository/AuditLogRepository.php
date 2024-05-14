<?php

namespace App\Repository;

use App\Entity\AuditLog;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AuditLog>
 *
 * @method AuditLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuditLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuditLog[]    findAll()
 * @method AuditLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuditLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuditLog::class);
    }

    public function add(AuditLog $auditLog): void
    {
        $em = $this->getEntityManager();
        $em->persist($auditLog);
        $em->flush();
    }

    public function getPaginatedResults(int $page = 1, int $perPage = 25): Paginator
    {
        $query = $this->createQueryBuilder('al')
            ->orderBy('al.createdAt', 'DESC');

        return (new Paginator($query))->paginate($page, $perPage);
    }
}

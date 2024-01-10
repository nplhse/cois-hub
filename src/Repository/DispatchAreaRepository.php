<?php

namespace App\Repository;

use App\Entity\DispatchArea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DispatchArea>
 *
 * @method DispatchArea|null find($id, $lockMode = null, $lockVersion = null)
 * @method DispatchArea|null findOneBy(array $criteria, array $orderBy = null)
 * @method DispatchArea[]    findAll()
 * @method DispatchArea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DispatchAreaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DispatchArea::class);
    }

    //    /**
    //     * @return DispatchArea[] Returns an array of DispatchArea objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DispatchArea
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

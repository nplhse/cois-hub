<?php

namespace App\Repository;

use App\Entity\SupplyArea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SupplyArea>
 *
 * @method SupplyArea|null find($id, $lockMode = null, $lockVersion = null)
 * @method SupplyArea|null findOneBy(array $criteria, array $orderBy = null)
 * @method SupplyArea[]    findAll()
 * @method SupplyArea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupplyAreaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SupplyArea::class);
    }

    //    /**
    //     * @return SupplyArea[] Returns an array of SupplyArea objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SupplyArea
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

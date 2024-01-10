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

    public function add(SupplyArea $supplyArea): void
    {
        $this->getEntityManager()->persist($supplyArea);
        $this->getEntityManager()->flush();
    }

    public function saveAndFlush(SupplyArea $supplyArea): void
    {
        $this->getEntityManager()->persist($supplyArea);
        $this->getEntityManager()->flush();
    }

    public function remove(SupplyArea $supplyArea): void
    {
        $this->getEntityManager()->remove($supplyArea);
        $this->getEntityManager()->flush();
    }
}

<?php

namespace App\Repository;

use App\Entity\Hospital;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hospital>
 *
 * @method Hospital|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hospital|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hospital[]    findAll()
 * @method Hospital[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HospitalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hospital::class);
    }

    public function add(Hospital $hospital): void
    {
        $this->getEntityManager()->persist($hospital);
        $this->getEntityManager()->flush();
    }

    public function saveAndFlush(Hospital $hospital): void
    {
        $this->getEntityManager()->persist($hospital);
        $this->getEntityManager()->flush();
    }

    public function remove(Hospital $hospital): void
    {
        $this->getEntityManager()->remove($hospital);
        $this->getEntityManager()->flush();
    }
}

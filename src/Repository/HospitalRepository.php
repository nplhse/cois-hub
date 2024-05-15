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
        $em = $this->getEntityManager();
        $em->persist($hospital);
        $em->flush();
    }

    public function saveAndFlush(Hospital $hospital): void
    {
        $em = $this->getEntityManager();
        $em->persist($hospital);
        $em->flush();
    }

    public function remove(Hospital $hospital): void
    {
        $em = $this->getEntityManager();
        $em->remove($hospital);
        $em->flush();
    }
}

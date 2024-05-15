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

    public function add(DispatchArea $dispatchArea): void
    {
        $em = $this->getEntityManager();
        $em->persist($dispatchArea);
        $em->flush();
    }

    public function saveAndFlush(DispatchArea $dispatchArea): void
    {
        $em = $this->getEntityManager();
        $em->persist($dispatchArea);
        $em->flush();
    }

    public function remove(DispatchArea $dispatchArea): void
    {
        $em = $this->getEntityManager();
        $em->remove($dispatchArea);
        $em->flush();
    }
}

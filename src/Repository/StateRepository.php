<?php

namespace App\Repository;

use App\Entity\State;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<State>
 *
 * @method State|null find($id, $lockMode = null, $lockVersion = null)
 * @method State|null findOneBy(array $criteria, array $orderBy = null)
 * @method State[]    findAll()
 * @method State[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, State::class);
    }

    public function add(State $state): void
    {
        $em = $this->getEntityManager();
        $em->persist($state);
        $em->flush();
    }

    public function saveAndFlush(State $state): void
    {
        $em = $this->getEntityManager();
        $em->persist($state);
        $em->flush();
    }

    public function remove(State $state): void
    {
        $em = $this->getEntityManager();
        $em->remove($state);
        $em->flush();
    }
}

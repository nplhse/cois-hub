<?php

namespace App\EventListener;

use App\Entity\Traits\Blameable;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
final readonly class BlameableListener
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();
        $currentUser = $this->security->getUser();

        if (null === $currentUser) {
            return;
        }

        if (!in_array(Blameable::class, class_uses($entity), true)) {
            return;
        }

        if (isset($entity->getCreatedBy)) {
            return;
        }

        $entity->setCreatedBy($currentUser);
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();
        $currentUser = $this->security->getUser();

        if (null === $currentUser) {
            return;
        }

        if (!in_array(Blameable::class, class_uses($entity), true)) {
            return;
        }

        $entity->setUpdatedBy($currentUser);
    }
}

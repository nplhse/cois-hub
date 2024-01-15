<?php

namespace App\EventListener;

use App\Entity\Traits\Blameable;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
final class BlameableListener
{
    private ?UserInterface $user = null;

    public function __construct(
        private readonly Security $security,
    ) {
        $this->user = $this->security->getUser();
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if (null === $this->user) {
            return;
        }

        if (!in_array(Blameable::class, class_uses($entity), true)) {
            return;
        }

        if (null !== $entity->getCreatedBy) {
            return;
        }

        $entity->setCreatedBy($this->user);
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if (null === $this->user) {
            return;
        }

        if (!in_array(Blameable::class, class_uses($entity), true)) {
            return;
        }

        $entity->setUpdatedBy($this->user);
    }
}

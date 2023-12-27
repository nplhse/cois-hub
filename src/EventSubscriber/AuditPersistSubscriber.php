<?php

namespace App\EventSubscriber;

use App\Enum\AuditActions;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

#[AsDoctrineListener(event: Events::postPersist, priority: 500, connection: 'default')]
class AuditPersistSubscriber extends AuditSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'postPersist' => 'postPersist',
        ];
    }

    public function postPersist(PostPersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if (in_array($entity::class, $this->excludedEntities, true)) {
            return;
        }

        $entityData = $this->normalizeEntity($entity);

        $this->log(
            $this->getEntityType($entity),
            (int) $entity->getId(),
            AuditActions::INSERT,
            $entityData
        );
    }
}

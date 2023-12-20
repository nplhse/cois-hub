<?php

namespace App\EventSubscriber;

use App\Enum\AuditActions;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AuditPersistSubscriber extends AuditSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'postPersist' => 'onPostPersist',
        ];
    }

    public function onPostPersist(LifecycleEventArgs $args): void
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

<?php

namespace App\EventSubscriber;

use App\Enum\AuditActions;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AuditRemoveSubscriber extends AuditSubscriber implements EventSubscriberInterface
{
    /**
     * @var array|string[]
     */
    protected array $removals = [];

    public static function getSubscribedEvents(): array
    {
        return [
            'preRemove' => 'onPreRemove',
            'postRemove' => 'onPostRemove',
        ];
    }

    public function onPreRemove(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        $this->removals[] = $this->normalizeEntity($entity);
    }

    public function onPostRemove(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (in_array($entity::class, $this->excludedEntities, true)) {
            return;
        }

        /** @var array|string[] $entityData */
        $entityData = array_pop($this->removals);

        $this->log(
            $this->getEntityType($entity),
            (int) $entityData['id'],
            AuditActions::REMOVE,
            $entityData
        );
    }
}

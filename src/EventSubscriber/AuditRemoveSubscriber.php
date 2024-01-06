<?php

namespace App\EventSubscriber;

use App\Enum\AuditActions;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostRemoveEventArgs;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

#[AsDoctrineListener(event: Events::preRemove, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::postRemove, priority: 500, connection: 'default')]
class AuditRemoveSubscriber extends AuditSubscriber implements EventSubscriberInterface
{
    /**
     * @var array|string[]
     */
    protected array $removals = [];

    public static function getSubscribedEvents(): array
    {
        return [
            'preRemove' => 'preRemove',
            'postRemove' => 'postRemove',
        ];
    }

    public function preRemove(PreRemoveEventArgs $args): void
    {
        $entity = $args->getObject();

        $this->removals[] = $this->normalizeEntity($entity);
    }

    public function postRemove(PostRemoveEventArgs $args): void
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

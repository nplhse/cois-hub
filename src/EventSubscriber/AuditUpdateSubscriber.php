<?php

namespace App\EventSubscriber;

use App\Enum\AuditActions;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

#[AsDoctrineListener(event: Events::postUpdate, priority: 500, connection: 'default')]
class AuditUpdateSubscriber extends AuditSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'postUpdate' => 'postUpdate',
        ];
    }

    public function postUpdate(PostUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if (in_array($entity::class, $this->excludedEntities, true)) {
            return;
        }

        /** @var EntityManager $em */
        $em = $args->getObjectManager();
        $uow = $em->getUnitOfWork();

        $entityData = $uow->getEntityChangeSet($entity);

        $this->log(
            $this->getEntityType($entity),
            (int) $entity->getId(),
            AuditActions::UPDATE,
            $this->normalizeEntityData($entityData)
        );
    }

    /**
     * @param array<string, array<int, mixed>|PersistentCollection> $entityData
     *
     * @return array<string, PersistentCollection|array<int|string, mixed>> $entityData
     */
    private function normalizeEntityData(array $entityData): array
    {
        foreach ($entityData as $key => $value) {
            if (is_object($value[0])) {
                $entityData[$key][0] = $this->normalizeEntityId($value[0]);
            }

            if (is_object($value[1])) {
                $entityData[$key][1] = $this->normalizeEntityId($value[1]);
            }
        }

        foreach ($entityData as $field => $change) {
            if (in_array($field, $this->ignoredFields, true)) {
                unset($entityData[$field]);
                continue;
            }

            $entityData[$field] = [
                'from' => $change[0],
                'to' => $change[1],
            ];
        }

        return $entityData;
    }
}

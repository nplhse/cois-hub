<?php

namespace App\EventSubscriber;

use App\Enum\AuditActions;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AuditUpdateSubscriber extends AuditSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'postUpdate' => 'onPostUpdate',
        ];
    }

    public function onPostUpdate(LifecycleEventArgs $args): void
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

            if ('content' === $field) {
                $entityData[$field] = [
                    'from' => (strlen((string) $change[0]) > 53) ? substr((string) $change[0], 0, 50).'...' : $change[0],
                    'to' => (strlen((string) $change[1]) > 53) ? substr((string) $change[1], 0, 50).'...' : $change[1],
                ];

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

<?php

namespace App\EventSubscriber;

use App\Entity\AuditLog;
use App\Enum\AuditActions;
use App\Service\AuditLogger;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class AuditSubscriber
{
    /**
     * @var array|string[]
     */
    protected array $excludedEntities = [
        AuditLog::class,
    ];

    /**
     * @var array|string[]
     */
    protected array $ignoredFields = [
        'createdAt',
        'updatedAt',
        'password',
    ];

    public function __construct(
        private readonly AuditLogger $auditLogger,
    ) {
    }

    /**
     * @param array<array-key,mixed> $entityData
     */
    protected function log(string $entityType, int $entityId, AuditActions $action, array $entityData): void
    {
        $this->auditLogger->log($entityType, $entityId, $action, $entityData);
    }

    protected function getEntityType(object $entity): string
    {
        return str_replace('App\Entity\\', '', $entity::class);
    }

    /**
     * @return array<array-key,string>
     *
     * @throws ExceptionInterface
     */
    protected function normalizeEntity(object $entity): array
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        return (new Serializer($normalizers, $encoders))->normalize(
            $entity,
            null
        );
    }

    protected function normalizeEntityId(object $entity): mixed
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        return (new Serializer($normalizers, $encoders))->normalize(
            $entity,
            null,
            [AbstractNormalizer::ATTRIBUTES => ['id']]
        );
    }
}

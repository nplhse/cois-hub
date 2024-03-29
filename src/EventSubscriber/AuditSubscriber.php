<?php

namespace App\EventSubscriber;

use App\Entity\AuditLog;
use App\Entity\CookieConsent;
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
        CookieConsent::class,
    ];

    /**
     * @var array|string[]
     */
    protected array $ignoredFields = [
        'createdAt',
        'updatedAt',
        'password',
    ];

    /** @var array <array-key, mixed> */
    protected array $includedAttributes = [
        'id',
        'name',
        'dispatchArea' => ['id', 'name'],
        'state' => ['id', 'name'],
        'supplyArea' => ['id', 'name'],
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
            null,
            [AbstractNormalizer::ATTRIBUTES => $this->includedAttributes]
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

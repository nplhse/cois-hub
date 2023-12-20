<?php

namespace App\Entity;

use App\Repository\AuditLogRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

#[ORM\Entity(repositoryClass: AuditLogRepository::class)]
class AuditLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __construct(
        #[ORM\Column(length: 255)]
        private string $entityType,
        #[ORM\Column]
        private int $entityId,
        #[ORM\Column]
        private \DateTimeImmutable $createdAt,
        #[ORM\Column(length: 255)]
        private string $requestRoute,
        /** @var array<string|array<int|string,mixed>|PersistentCollection> $eventData */
        #[ORM\Column]
        private array $eventData,
        #[ORM\Column(length: 255, nullable: true)]
        private ?string $action,
        #[ORM\Column(length: 255, nullable: true)]
        private ?string $ipAddress,
        #[ORM\ManyToOne]
        private ?User $user = null
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntityType(): string
    {
        return $this->entityType;
    }

    public function getEntityId(): int
    {
        return $this->entityId;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function getRequestRoute(): string
    {
        return $this->requestRoute;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return array<string|array<int|string,mixed>|PersistentCollection> $eventData
     */
    public function getEventData(): array
    {
        return $this->eventData;
    }
}

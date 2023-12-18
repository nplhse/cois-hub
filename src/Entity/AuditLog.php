<?php

namespace App\Entity;

use App\Repository\AuditLogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuditLogRepository::class)]
class AuditLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $entityType;

    #[ORM\Column]
    private int $entityId;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $action = null;

    #[ORM\Column(length: 255)]
    private string $requestRoute;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ipAddress = null;

    public function __construct(
        string $entityType,
        int $entityId,
        \DateTimeImmutable $createdAt,
        string $requestRoute,
        string $action = null,
        string $ipAddress = null
    ) {
        $this->entityType = $entityType;
        $this->entityId = $entityId;
        $this->createdAt = $createdAt;
        $this->action = $action;
        $this->requestRoute = $requestRoute;
        $this->ipAddress = $ipAddress;
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
}

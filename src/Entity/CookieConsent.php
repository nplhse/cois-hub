<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\CookieConsentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CookieConsentRepository::class)]
#[ORM\HasLifecycleCallbacks]
class CookieConsent
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private int $id;

    #[ORM\Column()]
    private string $lookupKey;

    #[ORM\Column()]
    private string $ipAddress;

    /**
     * @var array<array-key, string>
     */
    #[ORM\Column()]
    private array $categories = [];

    #[ORM\Column()]
    protected \DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    protected ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLookupKey(): ?string
    {
        return $this->lookupKey;
    }

    public function setLookupKey(string $lookupKey): self
    {
        $this->lookupKey = $lookupKey;

        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * @return array<array-key, string>
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param array<array-key, string> $categories
     */
    public function setCategories(array $categories): self
    {
        $this->categories = $categories;

        return $this;
    }
}

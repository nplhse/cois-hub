<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\DispatchAreaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DispatchAreaRepository::class)]
#[ORM\HasLifecycleCallbacks]
class DispatchArea implements \Stringable
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\ManyToOne(inversedBy: 'dispatchAreas')]
    #[ORM\JoinColumn(nullable: false)]
    private State $state;

    #[ORM\ManyToOne(inversedBy: 'dispatchArea')]
    #[ORM\JoinColumn(nullable: true)]
    private ?SupplyArea $supplyArea = null;

    #[ORM\Column()]
    protected \DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    protected ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getState(): State
    {
        return $this->state;
    }

    public function setState(State $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getSupplyArea(): ?SupplyArea
    {
        return $this->supplyArea;
    }

    public function setSupplyArea(?SupplyArea $supplyArea): static
    {
        $this->supplyArea = $supplyArea;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}

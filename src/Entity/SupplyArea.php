<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\SupplyAreaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupplyAreaRepository::class)]
#[ORM\HasLifecycleCallbacks]
class SupplyArea implements \Stringable
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    /**
     * @var Collection<int, DispatchArea>
     */
    #[ORM\OneToMany(mappedBy: 'supplyArea', targetEntity: DispatchArea::class)]
    private Collection $dispatchArea;

    #[ORM\Column()]
    protected \DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    protected ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->dispatchArea = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, DispatchArea>
     */
    public function getDispatchArea(): Collection
    {
        return $this->dispatchArea;
    }

    public function addDispatchArea(DispatchArea $dispatchArea): static
    {
        if (!$this->dispatchArea->contains($dispatchArea)) {
            $this->dispatchArea->add($dispatchArea);
            $dispatchArea->setSupplyArea($this);
        }

        return $this;
    }

    public function removeDispatchArea(DispatchArea $dispatchArea): static
    {
        if ($this->dispatchArea->removeElement($dispatchArea)) {
            // set the owning side to null (unless already changed)
            if ($dispatchArea->getSupplyArea() === $this) {
                $dispatchArea->setSupplyArea(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}

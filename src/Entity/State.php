<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\StateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StateRepository::class)]
#[ORM\HasLifecycleCallbacks]
class State
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
    #[ORM\OneToMany(mappedBy: 'state', targetEntity: DispatchArea::class)]
    private Collection $dispatchAreas;

    #[ORM\Column()]
    protected \DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    protected ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->dispatchAreas = new ArrayCollection();
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
    public function getDispatchAreas(): Collection
    {
        return $this->dispatchAreas;
    }

    public function addDispatchArea(DispatchArea $dispatchArea): static
    {
        if (!$this->dispatchAreas->contains($dispatchArea)) {
            $this->dispatchAreas->add($dispatchArea);
            $dispatchArea->setState($this);
        }

        return $this;
    }

    public function removeDispatchArea(DispatchArea $dispatchArea): static
    {
        if ($this->dispatchAreas->removeElement($dispatchArea)) {
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}

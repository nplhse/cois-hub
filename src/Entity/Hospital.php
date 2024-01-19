<?php

namespace App\Entity;

use App\Entity\Traits\Blameable;
use App\Entity\Traits\Timestampable;
use App\Enum\HospitalLocation;
use App\Enum\HospitalSize;
use App\Enum\HospitalTier;
use App\Repository\HospitalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HospitalRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Hospital implements \Stringable
{
    use Blameable;
    use Timestampable;

    final public const SMALL_HOSPITAL = 250;
    final public const LARGE_HOSPITAL = 750;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\ManyToOne(inversedBy: 'hospitals')]
    #[ORM\JoinColumn(nullable: false)]
    private User $owner;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'associatedHospitals')]
    private Collection $associatedUsers;

    #[ORM\Embedded(class: Address::class)]
    private Address $address;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private State $state;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private DispatchArea $dispatchArea;

    #[ORM\ManyToOne]
    private ?SupplyArea $supplyArea = null;

    #[ORM\Column(enumType: HospitalSize::class)]
    private HospitalSize $size;

    #[ORM\Column]
    private int $beds;

    #[ORM\Column(enumType: HospitalLocation::class)]
    private HospitalLocation $location;

    #[ORM\Column(enumType: HospitalTier::class)]
    private HospitalTier $tier;

    #[ORM\Column()]
    protected \DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    protected ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    protected User $createdBy;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    protected ?User $updatedBy = null;

    public function __construct()
    {
        $this->address = new Address();
        $this->associatedUsers = new ArrayCollection();
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

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getAssociatedUsers(): Collection
    {
        return $this->associatedUsers;
    }

    public function addAssociatedUser(User $user): static
    {
        if (!$this->associatedUsers->contains($user)) {
            $this->associatedUsers->add($user);
            $user->addAssociatedHospital($this);
        }

        return $this;
    }

    public function removeAssociatedUser(User $user): static
    {
        if ($this->associatedUsers->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($this->associatedUsers->contains($user)) {
                $user->removeAssociatedHospital($this);
            }
        }

        return $this;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): static
    {
        $this->address = $address;

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

    public function getDispatchArea(): ?DispatchArea
    {
        return $this->dispatchArea;
    }

    public function setDispatchArea(DispatchArea $dispatchArea): static
    {
        $this->dispatchArea = $dispatchArea;

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

    public function getSize(): HospitalSize
    {
        return $this->size;
    }

    public function setSize(HospitalSize $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getBeds(): int
    {
        return $this->beds;
    }

    public function setBeds(int $beds): static
    {
        if ($beds <= 0) {
            throw new \InvalidArgumentException(sprintf('Beds must be positive integer, not %d', $beds));
        }

        $this->beds = $beds;

        if ($beds <= self::SMALL_HOSPITAL) {
            $this->size = HospitalSize::SMALL;
        } elseif ($beds < self::LARGE_HOSPITAL) {
            $this->size = HospitalSize::MEDIUM;
        } else {
            $this->size = HospitalSize::LARGE;
        }

        return $this;
    }

    public function getLocation(): HospitalLocation
    {
        return $this->location;
    }

    public function setLocation(HospitalLocation $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getTier(): HospitalTier
    {
        return $this->tier;
    }

    public function setTier(HospitalTier $tier): static
    {
        $this->tier = $tier;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}

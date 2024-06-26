<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User.
 *
 * This class represents a user entity.
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, \Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private string $username;

    /**
     * @var array<array-key,string> $roles
     */
    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private string $password;

    private ?string $plainPassword = null;

    #[ORM\Column(length: 255)]
    private string $email;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private bool $hasCredentialsExpired = false;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $isVerified = false;

    #[ORM\Column]
    private bool $isPublic = false;

    /**
     * @var Collection<int, Hospital>
     */
    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Hospital::class)]
    private Collection $hospitals;

    /**
     * @var Collection<int, Hospital>
     */
    #[ORM\ManyToMany(mappedBy: 'associatedUsers', targetEntity: Hospital::class)]
    private Collection $associatedHospitals;

    public function __construct()
    {
        $this->hospitals = new ArrayCollection();
        $this->associatedHospitals = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array<array-key,string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function hasCredentialsExpired(): bool
    {
        return $this->hasCredentialsExpired;
    }

    public function setCredentialsExpired(bool $hasCredentialsExpired): static
    {
        $this->hasCredentialsExpired = $hasCredentialsExpired;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): static
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getUsername();
    }

    /**
     * @return Collection<int, Hospital>
     */
    public function getHospitals(): Collection
    {
        return $this->hospitals;
    }

    public function addHospital(Hospital $hospital): static
    {
        if (!$this->hospitals->contains($hospital)) {
            $this->hospitals->add($hospital);
            $hospital->setOwner($this);
        }

        return $this;
    }

    public function removeHospital(Hospital $hospital): static
    {
        $this->hospitals->removeElement($hospital);

        return $this;
    }

    /**
     * @return Collection<int, Hospital>
     */
    public function getAssociatedHospitals(): Collection
    {
        return $this->associatedHospitals;
    }

    public function addAssociatedHospital(Hospital $hospital): static
    {
        if (!$this->associatedHospitals->contains($hospital)) {
            $this->associatedHospitals->add($hospital);
            $hospital->addAssociatedUser($this);
        }

        return $this;
    }

    public function removeAssociatedHospital(Hospital $hospital): static
    {
        // set the owning side to null (unless already changed)
        if ($this->associatedHospitals->removeElement($hospital) && $this->associatedHospitals->contains($hospital)) {
            $hospital->removeAssociatedUser($this);
        }

        return $this;
    }
}

<?php

namespace App\DataTransferObjects;

use Symfony\Component\Validator\Constraints as Assert;

class UserAdminDTO
{
    private int $id;

    #[Assert\NoSuspiciousCharacters]
    private string $username = '';

    #[Assert\Email]
    private string $email = '';

    private ?string $password = null;

    /**
     * @var array<array-key,string>
     */
    private array $roles;

    private bool $isVerified;

    private bool $hasCredentialsExpired;

    private bool $isPublic;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return array<array-key,string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array<array-key,string> $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): void
    {
        $this->isVerified = $isVerified;
    }

    public function getCredentialsExpired(): bool
    {
        return $this->hasCredentialsExpired;
    }

    public function setCredentialsExpired(bool $hasCredentialsExpired): void
    {
        $this->hasCredentialsExpired = $hasCredentialsExpired;
    }

    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): void
    {
        $this->isPublic = $isPublic;
    }
}

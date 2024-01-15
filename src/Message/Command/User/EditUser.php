<?php

namespace App\Message\Command\User;

final readonly class EditUser
{
    public function __construct(
        private int $id,
        private string $username,
        private ?string $password,
        private string $email,
        /**
         * @var array<array-key,string> $roles
         */
        private array $roles,
        private bool $isVerified,
        private bool $hasCredentialsExpired,
        private bool $isPublic,
    ) {
    }

    public function getUserId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return array<array-key,string> $roles
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function hasCredentialsExpired(): bool
    {
        return $this->hasCredentialsExpired;
    }

    public function isPublic(): bool
    {
        return $this->isPublic;
    }
}

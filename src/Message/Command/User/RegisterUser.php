<?php

namespace App\Message\Command\User;

final readonly class RegisterUser
{
    public function __construct(
        private string $username,
        private string $email,
        private string $password
    ) {
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}

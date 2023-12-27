<?php

namespace App\DataTransferObjects;

use Symfony\Component\Validator\Constraints as Assert;

class RegisterTypeDTO
{
    #[Assert\NoSuspiciousCharacters]
    private string $username = '';

    #[Assert\Email]
    private string $email = '';

    private string $password = '';

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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}

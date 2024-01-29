<?php

namespace App\Message\Command\User;

final readonly class UpdateUserEmail
{
    public function __construct(
        private int $userId,
        private string $email,
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}

<?php

namespace App\Command\User;

final readonly class UpdateUserPasswordCommand
{
    public function __construct(
        private int $userId,
        private string $password,
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}

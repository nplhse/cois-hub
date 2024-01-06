<?php

namespace App\Command\User;

final readonly class DeleteUserCommand
{
    public function __construct(
        private int $userId
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}

<?php

namespace App\Message\Command\User;

final readonly class DeleteUser
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

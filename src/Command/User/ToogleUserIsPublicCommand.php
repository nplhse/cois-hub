<?php

namespace App\Command\User;

final readonly class ToogleUserIsPublicCommand
{
    public function __construct(
        private int $userId,
        private bool $isPublic,
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getIsPublic(): bool
    {
        return $this->isPublic;
    }
}

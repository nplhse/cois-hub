<?php

declare(strict_types=1);

namespace App\Event\User;

use App\Contracts\EventInterface;
use App\Event\NamedEvent;
use Symfony\Contracts\EventDispatcher\Event;

class UserToogledIsPublic extends Event implements EventInterface
{
    use NamedEvent;

    final public const NAME = 'app.user.toogled_is_public';

    public function __construct(
        private readonly int $userId,
        private readonly bool $isPublic
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

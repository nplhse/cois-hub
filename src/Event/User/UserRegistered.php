<?php

declare(strict_types=1);

namespace App\Event\User;

use App\Contracts\EventInterface;
use App\Event\NamedEvent;
use Symfony\Contracts\EventDispatcher\Event;

class UserRegistered extends Event implements EventInterface
{
    use NamedEvent;

    final public const NAME = 'app.user.registered';

    public function __construct(
        private readonly int $userId
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}

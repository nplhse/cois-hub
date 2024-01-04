<?php

declare(strict_types=1);

namespace App\Event\User;

use App\Contracts\EventInterface;
use App\Event\NamedEvent;
use Symfony\Contracts\EventDispatcher\Event;

class UserDeleted extends Event implements EventInterface
{
    use NamedEvent;

    final public const NAME = 'app.user.deleted';

    public function __construct(
        private readonly int $userId,
        private readonly string $username,
        private readonly string $email,
        /**
         * @var array<array-key,string> $roles
         */
        private readonly array $roles
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return array<array-key,string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }
}

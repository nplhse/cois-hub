<?php

declare(strict_types=1);

namespace App\Event\Area;

use App\Contracts\EventInterface;
use App\Event\NamedEvent;
use Symfony\Contracts\EventDispatcher\Event;

class StateCreated extends Event implements EventInterface
{
    use NamedEvent;

    final public const NAME = 'app.state.created';

    public function __construct(
        private readonly int $id
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }
}

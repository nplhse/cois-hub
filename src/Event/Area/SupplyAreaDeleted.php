<?php

declare(strict_types=1);

namespace App\Event\Area;

use App\Contracts\EventInterface;
use App\Event\NamedEvent;
use Symfony\Contracts\EventDispatcher\Event;

class SupplyAreaDeleted extends Event implements EventInterface
{
    use NamedEvent;

    final public const NAME = 'app.supply_area.deleted';

    public function __construct(
        private readonly int $id,
        private readonly string $name,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

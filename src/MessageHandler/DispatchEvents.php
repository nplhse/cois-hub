<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Contracts\EventInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Adds the possibility to dispatch Events just by using this trait.
 */
trait DispatchEvents
{
    private EventDispatcherInterface $eventDispatcher;

    #[Required]
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function dispatchEvent(EventInterface $event): void
    {
        $this->eventDispatcher->dispatch($event, $event->getName());
    }
}

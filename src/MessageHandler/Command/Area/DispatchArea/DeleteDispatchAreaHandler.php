<?php

namespace App\MessageHandler\Command\Area\DispatchArea;

use App\Event\Area\DispatchAreaDeleted;
use App\Message\Command\Area\DispatchArea\DeleteDispatchArea;
use App\MessageHandler\DispatchEvents;
use App\Repository\DispatchAreaRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final class DeleteDispatchAreaHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly DispatchAreaRepository $dispatchAreaRepository
    ) {
    }

    public function __invoke(DeleteDispatchArea $command): void
    {
        $dispatchArea = $this->dispatchAreaRepository->findOneBy(['id' => $command->getId()]);

        if (null === $dispatchArea) {
            throw new \LogicException('Cannot find dispatch area for given id.');
        }

        // Create the event before deleting the object
        $event = new DispatchAreaDeleted($dispatchArea->getId(), $dispatchArea->getName());

        $this->dispatchAreaRepository->remove($dispatchArea);

        $this->dispatchEvent($event);
    }
}

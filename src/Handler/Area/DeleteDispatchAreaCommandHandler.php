<?php

namespace App\Handler\Area;

use App\Command\Area\DeleteDispatchAreaCommand;
use App\Event\Area\DispatchAreaDeleted;
use App\Handler\DispatchEvents;
use App\Repository\DispatchAreaRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class DeleteDispatchAreaCommandHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly DispatchAreaRepository $dispatchAreaRepository
    ) {
    }

    public function __invoke(DeleteDispatchAreaCommand $command): void
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

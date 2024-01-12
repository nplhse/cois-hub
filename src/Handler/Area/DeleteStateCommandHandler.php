<?php

namespace App\Handler\Area;

use App\Command\Area\DeleteStateCommand;
use App\Event\Area\StateDeleted;
use App\Handler\DispatchEvents;
use App\Repository\StateRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class DeleteStateCommandHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly StateRepository $stateRepository
    ) {
    }

    public function __invoke(DeleteStateCommand $command): void
    {
        $state = $this->stateRepository->findOneBy(['id' => $command->getId()]);

        if (null === $state) {
            throw new \LogicException('Cannot find state for given id.');
        }

        if (true !== $state->getDispatchAreas()->isEmpty()) {
            throw new \LogicException('Cannot delete state with dispatch areas.');
        }

        // Create the event before deleting the object
        $event = new StateDeleted($state->getId(), $state->getName());

        $this->stateRepository->remove($state);

        $this->dispatchEvent($event);
    }
}

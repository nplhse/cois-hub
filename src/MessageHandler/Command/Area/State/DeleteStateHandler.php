<?php

namespace App\MessageHandler\Command\Area\State;

use App\Event\Area\StateDeleted;
use App\Message\Command\Area\State\DeleteState;
use App\MessageHandler\DispatchEvents;
use App\Repository\StateRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final class DeleteStateHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly StateRepository $stateRepository
    ) {
    }

    public function __invoke(DeleteState $command): void
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

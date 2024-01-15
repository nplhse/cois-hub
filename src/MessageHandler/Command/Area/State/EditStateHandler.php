<?php

namespace App\MessageHandler\Command\Area\State;

use App\Event\Area\StateUpdated;
use App\Message\Command\Area\State\UpdateState;
use App\MessageHandler\DispatchEvents;
use App\Repository\StateRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final class EditStateHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly StateRepository $stateRepository
    ) {
    }

    public function __invoke(UpdateState $command): void
    {
        $state = $this->stateRepository->findOneBy(['id' => $command->getId()]);

        if (null === $state) {
            throw new \LogicException('Cannot find state for given id.');
        }

        $state->setName($command->getName());
        $state->setUpdatedAt(new \DateTimeImmutable('now'));

        $this->stateRepository->saveAndFlush($state);

        $event = new StateUpdated($state->getId());
        $this->dispatchEvent($event);
    }
}

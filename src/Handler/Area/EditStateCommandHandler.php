<?php

namespace App\Handler\Area;

use App\Command\Area\UpdateStateCommand;
use App\Event\Area\StateUpdated;
use App\Handler\DispatchEvents;
use App\Repository\StateRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class EditStateCommandHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly StateRepository $stateRepository
    ) {
    }

    public function __invoke(UpdateStateCommand $command): void
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

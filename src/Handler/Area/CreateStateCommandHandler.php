<?php

namespace App\Handler\Area;

use App\Command\Area\CreateStateCommand;
use App\Entity\State;
use App\Event\Area\StateCreated;
use App\Handler\DispatchEvents;
use App\Repository\StateRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateStateCommandHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly StateRepository $stateRepository
    ) {
    }

    public function __invoke(CreateStateCommand $command): State
    {
        $state = new State();

        $state->setName($command->getName());
        $state->setCreatedAt(new \DateTimeImmutable('now'));

        $this->stateRepository->add($state);

        $event = new StateCreated($state->getId());
        $this->dispatchEvent($event);

        return $state;
    }
}

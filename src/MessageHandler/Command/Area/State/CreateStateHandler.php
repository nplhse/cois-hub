<?php

namespace App\MessageHandler\Command\Area\State;

use App\Entity\State;
use App\Event\Area\StateCreated;
use App\Message\Command\Area\State\CreateState;
use App\MessageHandler\DispatchEvents;
use App\Repository\StateRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final class CreateStateHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly StateRepository $stateRepository
    ) {
    }

    public function __invoke(CreateState $command): State
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

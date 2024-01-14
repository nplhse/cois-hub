<?php

namespace App\MessageHandler\Command\Area\DispatchArea;

use App\Entity\DispatchArea;
use App\Event\Area\DispatchAreaCreated;
use App\Message\Command\Area\DispatchArea\CreateDispatchArea;
use App\MessageHandler\DispatchEvents;
use App\Repository\DispatchAreaRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final class CreateDispatchAreaHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly DispatchAreaRepository $dispatchAreaRepository
    ) {
    }

    public function __invoke(CreateDispatchArea $command): DispatchArea
    {
        $dispatchArea = new DispatchArea();

        $dispatchArea->setName($command->getName());
        $dispatchArea->setState($command->getState());
        $dispatchArea->setSupplyArea($command->getSupplyArea());
        $dispatchArea->setCreatedAt(new \DateTimeImmutable('now'));

        $this->dispatchAreaRepository->add($dispatchArea);

        $event = new DispatchAreaCreated($dispatchArea->getId());
        $this->dispatchEvent($event);

        return $dispatchArea;
    }
}

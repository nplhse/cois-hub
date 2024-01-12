<?php

namespace App\Handler\Area;

use App\Command\Area\CreateDispatchAreaCommand;
use App\Entity\DispatchArea;
use App\Event\Area\DispatchAreaCreated;
use App\Handler\DispatchEvents;
use App\Repository\DispatchAreaRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateDispatchAreaCommandHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly DispatchAreaRepository $dispatchAreaRepository
    ) {
    }

    public function __invoke(CreateDispatchAreaCommand $command): DispatchArea
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

<?php

namespace App\Handler\Area;

use App\Command\Area\UpdateDispatchAreaCommand;
use App\Event\Area\DispatchAreaUpdated;
use App\Handler\DispatchEvents;
use App\Repository\DispatchAreaRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class EditDispatchAreaCommandHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly DispatchAreaRepository $dispatchAreaRepository
    ) {
    }

    public function __invoke(UpdateDispatchAreaCommand $command): void
    {
        $dispatchArea = $this->dispatchAreaRepository->findOneBy(['id' => $command->getId()]);

        if (null === $dispatchArea) {
            throw new \LogicException('Cannot find DispatchArea for given id.');
        }

        $dispatchArea->setName($command->getName());
        $dispatchArea->setState($command->getState());
        $dispatchArea->setSupplyArea($command->getSupplyArea());
        $dispatchArea->setUpdatedAt(new \DateTimeImmutable('now'));

        $this->dispatchAreaRepository->saveAndFlush($dispatchArea);

        $event = new DispatchAreaUpdated($dispatchArea->getId());
        $this->dispatchEvent($event);
    }
}

<?php

namespace App\MessageHandler\Command\Area\SupplyArea;

use App\Event\Area\SupplyAreaUpdated;
use App\Message\Command\Area\SupplyArea\UpdateSupplyArea;
use App\MessageHandler\DispatchEvents;
use App\Repository\SupplyAreaRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final class EditSupplyAreaHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly SupplyAreaRepository $supplyAreaRepository
    ) {
    }

    public function __invoke(UpdateSupplyArea $command): void
    {
        $supplyArea = $this->supplyAreaRepository->findOneBy(['id' => $command->getId()]);

        if (null === $supplyArea) {
            throw new \LogicException('Cannot find SupplyArea for given id.');
        }

        $supplyArea->setName($command->getName());
        $supplyArea->setUpdatedAt(new \DateTimeImmutable('now'));

        $this->supplyAreaRepository->saveAndFlush($supplyArea);

        $event = new SupplyAreaUpdated($supplyArea->getId());
        $this->dispatchEvent($event);
    }
}

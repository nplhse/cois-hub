<?php

namespace App\Handler\Area;

use App\Command\Area\UpdateSupplyAreaCommand;
use App\Event\Area\SupplyAreaUpdated;
use App\Handler\DispatchEvents;
use App\Repository\SupplyAreaRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class EditSupplyAreaCommandHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly SupplyAreaRepository $supplyAreaRepository
    ) {
    }

    public function __invoke(UpdateSupplyAreaCommand $command): void
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

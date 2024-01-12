<?php

namespace App\Handler\Area;

use App\Command\Area\DeleteSupplyAreaCommand;
use App\Event\Area\SupplyAreaDeleted;
use App\Handler\DispatchEvents;
use App\Repository\SupplyAreaRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class DeleteSupplyAreaCommandHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly SupplyAreaRepository $supplyAreaRepository
    ) {
    }

    public function __invoke(DeleteSupplyAreaCommand $command): void
    {
        $supplyArea = $this->supplyAreaRepository->findOneBy(['id' => $command->getId()]);

        if (null === $supplyArea) {
            throw new \LogicException('Cannot find dispatch area for given id.');
        }

        // Create the event before deleting the object
        $event = new SupplyAreaDeleted($supplyArea->getId(), $supplyArea->getName());

        $this->supplyAreaRepository->remove($supplyArea);

        $this->dispatchEvent($event);
    }
}

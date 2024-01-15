<?php

namespace App\MessageHandler\Command\Area\SupplyArea;

use App\Event\Area\SupplyAreaDeleted;
use App\Message\Command\Area\SupplyArea\DeleteSupplyArea;
use App\MessageHandler\DispatchEvents;
use App\Repository\SupplyAreaRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final class DeleteSupplyAreaHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly SupplyAreaRepository $supplyAreaRepository
    ) {
    }

    public function __invoke(DeleteSupplyArea $command): void
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

<?php

namespace App\MessageHandler\Command\Area\SupplyArea;

use App\Entity\SupplyArea;
use App\Event\Area\SupplyAreaCreated;
use App\Message\Command\Area\SupplyArea\CreateSupplyArea;
use App\MessageHandler\DispatchEvents;
use App\Repository\SupplyAreaRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final class CreateSupplyAreaHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly SupplyAreaRepository $supplyAreaRepository
    ) {
    }

    public function __invoke(CreateSupplyArea $command): SupplyArea
    {
        $supplyArea = new SupplyArea();

        $supplyArea->setName($command->getName());
        $supplyArea->setCreatedAt(new \DateTimeImmutable('now'));

        $this->supplyAreaRepository->add($supplyArea);

        $event = new SupplyAreaCreated($supplyArea->getId());
        $this->dispatchEvent($event);

        return $supplyArea;
    }
}

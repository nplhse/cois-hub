<?php

namespace App\Handler\Area;

use App\Command\Area\CreateSupplyAreaCommand;
use App\Entity\SupplyArea;
use App\Event\Area\SupplyAreaCreated;
use App\Handler\DispatchEvents;
use App\Repository\SupplyAreaRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateSupplyAreaCommandHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly SupplyAreaRepository $supplyAreaRepository
    ) {
    }

    public function __invoke(CreateSupplyAreaCommand $command): SupplyArea
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

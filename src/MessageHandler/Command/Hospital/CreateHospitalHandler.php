<?php

namespace App\MessageHandler\Command\Hospital;

use App\Entity\Hospital;
use App\Message\Command\Hospital\CreateHospital;
use App\Message\Event\Hospital\HospitalCreated;
use App\Repository\HospitalRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class CreateHospitalHandler
{
    public function __construct(
        private HospitalRepository $hospitalRepository,
        private MessageBusInterface $eventBus,
    ) {
    }

    public function __invoke(CreateHospital $command): ?int
    {
        $hospital = new Hospital();

        $hospital->setName($command->getName());
        $hospital->setOwner($command->getOwner());
        $hospital->setBeds($command->getBeds());
        $hospital->setLocation($command->getLocation());
        $hospital->setTier($command->getTier());
        $hospital->setAddress($command->getAddress());
        $hospital->setState($command->getState());
        $hospital->setDispatchArea($command->getDispatchArea());
        $hospital->setSupplyArea($command->getSupplyArea());

        $hospital->setCreatedAt(new \DateTimeImmutable('now'));

        $this->hospitalRepository->add($hospital);

        $event = new HospitalCreated($hospital->getId());
        $this->eventBus->dispatch($event);

        return $hospital->getId();
    }
}

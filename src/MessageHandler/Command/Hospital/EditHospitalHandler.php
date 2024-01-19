<?php

namespace App\MessageHandler\Command\Hospital;

use App\Message\Command\Hospital\UpdateHospital;
use App\Message\Event\Hospital\HospitalUpdated;
use App\Repository\HospitalRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class EditHospitalHandler
{
    public function __construct(
        private HospitalRepository $hospitalRepository,
        private MessageBusInterface $eventBus,
    ) {
    }

    public function __invoke(UpdateHospital $command): void
    {
        $hospital = $this->hospitalRepository->findOneBy(['id' => $command->getHospitalId()]);

        if (null === $hospital) {
            throw new \LogicException('Cannot find hospital for given id.');
        }

        $hospital->setName($command->getName());
        $hospital->setOwner($command->getOwner());
        $hospital->setBeds($command->getBeds());
        $hospital->setLocation($command->getLocation());
        $hospital->setTier($command->getTier());
        $hospital->setAddress($command->getAddress());
        $hospital->setState($command->getState());
        $hospital->setDispatchArea($command->getDispatchArea());
        $hospital->setSupplyArea($command->getSupplyArea());

        $this->hospitalRepository->saveAndFlush($hospital);

        $event = new HospitalUpdated($hospital->getId());
        $this->eventBus->dispatch($event);
    }
}

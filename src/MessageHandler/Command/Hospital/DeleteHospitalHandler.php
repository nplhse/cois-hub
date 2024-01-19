<?php

namespace App\MessageHandler\Command\Hospital;

use App\Message\Command\Hospital\DeleteHospital;
use App\Message\Event\Hospital\HospitalDeleted;
use App\MessageHandler\DispatchEvents;
use App\Repository\HospitalRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler(bus: 'command.bus')]
final class DeleteHospitalHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly HospitalRepository $hospitalRepository,
        private readonly MessageBusInterface $eventBus,
    ) {
    }

    public function __invoke(DeleteHospital $command): void
    {
        $hospital = $this->hospitalRepository->findOneBy(['id' => $command->getHospitalId()]);

        if (null === $hospital) {
            throw new \LogicException('Cannot find hospital for given id.');
        }

        // Create the event before deleting the object
        $event = new HospitalDeleted($hospital->getId(), $hospital->getName());

        $this->hospitalRepository->remove($hospital);

        $this->eventBus->dispatch($event);
    }
}

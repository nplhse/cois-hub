<?php

namespace App\MessageHandler\Command\Hospital;

use App\Message\Command\Hospital\UpdateHospitalAssociatedUsers;
use App\Message\Event\Hospital\HospitalUpdated;
use App\Repository\HospitalRepository;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class UpdateHospitalAssociatedUsersHandler
{
    public function __construct(
        private HospitalRepository $hospitalRepository,
        private UserRepository $userRepository,
        private MessageBusInterface $eventBus,
    ) {
    }

    public function __invoke(UpdateHospitalAssociatedUsers $command): void
    {
        $hospital = $this->hospitalRepository->findOneBy(['id' => $command->getHospitalId()]);

        if (null === $hospital) {
            throw new \LogicException('Cannot find hospital for given id.');
        }

        // Select Users first
        $users = $this->userRepository->findByUsernames($command->getAssociatedUsers());

        foreach ($users as $user) {
            $hospital->addAssociatedUser($user);
        }

        $this->hospitalRepository->saveAndFlush($hospital);

        $event = new HospitalUpdated($hospital->getId());
        $this->eventBus->dispatch($event);
    }
}

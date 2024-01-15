<?php

namespace App\MessageHandler\Command\User;

use App\Event\User\UserDeleted;
use App\Message\Command\User\DeleteUser;
use App\MessageHandler\DispatchEvents;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final class DeleteUserHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function __invoke(DeleteUser $command): void
    {
        $user = $this->userRepository->findOneBy(['id' => $command->getUserId()]);

        if (null === $user) {
            throw new \LogicException('Cannot find user for given id.');
        }

        // Create the event before deleting the object
        $event = new UserDeleted($user->getId(), $user->getUsername(), $user->getUsername(), $user->getRoles());

        $this->userRepository->remove($user);

        $this->dispatchEvent($event);
    }
}

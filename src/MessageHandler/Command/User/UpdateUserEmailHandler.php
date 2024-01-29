<?php

namespace App\MessageHandler\Command\User;

use App\Event\User\UserUpdatedEmail;
use App\Message\Command\User\UpdateUserEmail;
use App\MessageHandler\DispatchEvents;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final class UpdateUserEmailHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(UpdateUserEmail $command): void
    {
        $user = $this->userRepository->findOneBy(['id' => $command->getUserId()]);

        if (null === $user) {
            throw new \LogicException('Cannot find user for given id.');
        }

        $user->setEmail($command->getEmail());
        $user->setIsVerified(false);

        $this->userRepository->saveAndFlush($user);

        $event = new UserUpdatedEmail($user->getId());
        $this->dispatchEvent($event);
    }
}

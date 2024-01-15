<?php

namespace App\MessageHandler\Command\User;

use App\Event\User\UserUpdatedPassword;
use App\Message\Command\User\UpdateUserPassword;
use App\MessageHandler\DispatchEvents;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler(bus: 'command.bus')]
final class UpdateUserPasswordHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(UpdateUserPassword $command): void
    {
        $user = $this->userRepository->findOneBy(['id' => $command->getUserId()]);

        if (null === $user) {
            throw new \LogicException('Cannot find user for given id.');
        }

        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $command->getPassword()
            )
        );

        $user->setCredentialsExpired(false);

        $this->userRepository->saveAndFlush($user);

        $event = new UserUpdatedPassword($user->getId());
        $this->dispatchEvent($event);
    }
}

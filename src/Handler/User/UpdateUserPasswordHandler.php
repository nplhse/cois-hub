<?php

namespace App\Handler\User;

use App\Command\User\UpdateUserPasswordCommand;
use App\Event\User\UserUpdatedPassword;
use App\Handler\DispatchEvents;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
final class UpdateUserPasswordHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(UpdateUserPasswordCommand $command): void
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

        $this->userRepository->saveAndFlush($user);

        $event = new UserUpdatedPassword($user->getId());
        $this->dispatchEvent($event);
    }
}
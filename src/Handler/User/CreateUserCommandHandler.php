<?php

namespace App\Handler\User;

use App\Command\User\CreateUserCommand;
use App\Entity\User;
use App\Event\User\UserRegistered;
use App\Handler\DispatchEvents;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
final class CreateUserCommandHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly UserRepository $userRepository
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $user = new User();

        $user->setUsername($command->getUsername());
        $user->setEmail($command->getEmail());

        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $command->getPassword()
            )
        );

        $user->setCreatedAt(new \DateTimeImmutable('now'));
        $user->setRoles($command->getRoles());

        $user->setCredentialsExpired($command->hasCredentialsExpired());
        $user->setIsVerified($command->isVerified());
        $user->setIsPublic($command->isPublic());

        $this->userRepository->add($user);

        $event = new UserRegistered($user->getId());
        $this->dispatchEvent($event);
    }
}

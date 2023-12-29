<?php

namespace App\Handler\User;

use App\Command\User\RegisterUserCommand;
use App\Entity\User;
use App\Event\User\UserRegistered;
use App\Handler\DispatchEvents;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
final class RegisterUserCommandHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly UserRepository $userRepository
    ) {
    }

    public function __invoke(RegisterUserCommand $command): int
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
        $user->setRoles(['ROLE_USER']);
        $user->setHasCredentialsExpired(false);
        $user->setIsVerified(false);
        $user->setIsPublic(false);

        $this->userRepository->add($user);

        $event = new UserRegistered($user->getId());
        $this->dispatchEvent($event);

        return $user->getId();
    }
}

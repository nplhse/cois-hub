<?php

namespace App\Handler;

use App\Command\RegisterUserCommand;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
final readonly class RegisterUserCommandHandler
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
        private UserRepository $userRepository
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

        $this->userRepository->add($user);

        return $user->getId();
    }
}

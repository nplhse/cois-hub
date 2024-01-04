<?php

namespace App\Handler\User;

use App\Command\User\EditUserCommand;
use App\Event\User\UserEdited;
use App\Handler\DispatchEvents;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
final class EditUserCommandHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly UserRepository $userRepository
    ) {
    }

    public function __invoke(EditUserCommand $command): void
    {
        $user = $this->userRepository->findOneBy(['id' => $command->getUserId()]);

        if (null === $user) {
            throw new \LogicException('Cannot find user for given id.');
        }

        $user->setUsername($command->getUsername());
        $user->setEmail($command->getEmail());

        // Only set password if changed
        if (null !== $command->getPassword()) {
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $command->getPassword()
                )
            );
        }

        $user->setUpdatedAt(new \DateTimeImmutable('now'));
        $user->setRoles($command->getRoles());

        $user->setCredentialsExpired($command->hasCredentialsExpired());
        $user->setIsVerified($command->isVerified());
        $user->setIsPublic($command->isPublic());

        $this->userRepository->saveAndFlush($user);

        $event = new UserEdited($user->getId());
        $this->dispatchEvent($event);
    }
}

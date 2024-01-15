<?php

namespace App\MessageHandler\Command\User;

use App\Event\User\UserEdited;
use App\Message\Command\User\EditUser;
use App\MessageHandler\DispatchEvents;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler(bus: 'command.bus')]
final class EditUserHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly UserRepository $userRepository
    ) {
    }

    public function __invoke(EditUser $command): void
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

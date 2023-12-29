<?php

namespace App\Handler\User;

use App\Command\User\ToogleUserIsPublicCommand;
use App\Event\User\UserToogledIsPublic;
use App\Handler\DispatchEvents;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ToogleUserIsPublicCommandHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function __invoke(ToogleUserIsPublicCommand $command): void
    {
        $user = $this->userRepository->findOneBy(['id' => $command->getUserId()]);

        if (null === $user) {
            throw new \LogicException('Cannot find user for given id.');
        }

        if (true === $command->getIsPublic()) {
            $user->setIsPublic(true);
        }

        if (false === $command->getIsPublic()) {
            $user->setIsPublic(false);
        }

        $this->userRepository->saveAndFlush($user);

        $event = new UserToogledIsPublic($user->getId(), $user->isPublic());
        $this->dispatchEvent($event);
    }
}

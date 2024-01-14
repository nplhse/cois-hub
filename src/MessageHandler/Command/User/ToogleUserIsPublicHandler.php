<?php

namespace App\MessageHandler\Command\User;

use App\Event\User\UserToogledIsPublic;
use App\Message\Command\User\ToogleUserIsPublic;
use App\MessageHandler\DispatchEvents;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final class ToogleUserIsPublicHandler
{
    use DispatchEvents;

    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function __invoke(ToogleUserIsPublic $command): void
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

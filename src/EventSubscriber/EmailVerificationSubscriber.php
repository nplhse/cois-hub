<?php

namespace App\EventSubscriber;

use App\Event\User\UserRegistered;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\Translation\TranslatorInterface;

class EmailVerificationSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EmailVerifier $emailVerifier,
        private readonly TranslatorInterface $translator,
        private readonly string $appMailerSender,
        private readonly string $appMailerAddress,
    ) {
    }

    public function onUserRegistered(UserRegistered $event): void
    {
        $user = $this->userRepository->findOneBy(['id' => $event->getUserId()]);

        if (null === $user) {
            throw new \LogicException('Cannot send email to nonexistent user!');
        }

        // generate a signed url and email it to the user
        $this->emailVerifier->sendEmailConfirmation(
            'app_verify_email',
            $user,
            (new TemplatedEmail())
                ->from(new Address($this->appMailerAddress, $this->appMailerSender))
                ->to($user->getEmail())
                ->subject($this->translator->trans('email.verify_title'))
                ->htmlTemplate('emails/confirmation_email.html.twig')
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'app.user.registered' => 'onUserRegistered',
        ];
    }
}

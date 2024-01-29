<?php

namespace App\EventSubscriber;

use App\Event\User\UserRegistered;
use App\Event\User\UserResendEmailVerification;
use App\Event\User\UserUpdatedEmail;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class EmailVerificationSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private EmailVerifier $emailVerifier,
        private TranslatorInterface $translator,
        private string $appMailerSender,
        private string $appMailerAddress,
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

    public function onUserUpdatedEmail(UserUpdatedEmail $event): void
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
                ->htmlTemplate('emails/verify_email.html.twig')
        );
    }

    public function onResendEmail(UserResendEmailVerification $event): void
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
                ->htmlTemplate('emails/verify_email.html.twig')
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'app.user.registered' => 'onUserRegistered',
            'app.user.email_updated' => 'onUserUpdatedEmail',
            'app.user.resend_email_verification' => 'onResendEmail',
        ];
    }
}

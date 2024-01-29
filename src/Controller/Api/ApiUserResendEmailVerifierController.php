<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Event\User\UserResendEmailVerification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('ROLE_USER')]
class ApiUserResendEmailVerifierController extends AbstractController
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly TranslatorInterface $translator
    ) {
    }

    #[Route('/api/user/resend_email_verifier', name: 'app_api_user_resend_email_verifier')]
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (false === $user->isVerified()) {
            $event = new UserResendEmailVerification($user->getId());
            $this->eventDispatcher->dispatch($event);

            $this->addFlash('info', $this->translator->trans('flash.email_verification_sent'));
        }

        return $this->redirectToRoute('app_settings_account');
    }
}

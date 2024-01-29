<?php

namespace App\Controller\Settings;

use App\Entity\User;
use App\Form\User\UpdateUserEmailType;
use App\Message\Command\User\UpdateUserEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class UpdateUserEmailController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/settings/email', name: 'app_settings_email')]
    public function __invoke(\Symfony\Component\HttpFoundation\Request $request): Response
    {
        $form = $this->createForm(UpdateUserEmailType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $this->getUser();
            $data = $form->getData();

            $command = new UpdateUserEmail($user->getId(), (string) $data['email']);

            try {
                $this->messageBus->dispatch($command);
            } catch (HandlerFailedException) {
                $this->addFlash('danger', 'Sorry, something went wrong. Please try again later!');
            }

            $this->addFlash('success', $this->translator->trans('flash.email_updated'));

            return $this->redirectToRoute('app_settings_account');
        }

        return $this->render('settings/email.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

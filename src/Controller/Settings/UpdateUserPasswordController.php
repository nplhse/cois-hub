<?php

namespace App\Controller\Settings;

use App\Command\User\UpdateUserPasswordCommand;
use App\Entity\User;
use App\Form\UpdateUserPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('ROLE_USER')]
class UpdateUserPasswordController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/settings/password', name: 'app_settings_password')]
    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(UpdateUserPasswordType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $this->getUser();
            $data = $form->getData();

            $command = new UpdateUserPasswordCommand($user->getId(), $data['password']);
            $this->messageBus->dispatch($command);

            $this->addFlash('success', $this->translator->trans('flash.password_updated'));

            return $this->redirectToRoute('app_settings_account');
        }

        return $this->render('settings/password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

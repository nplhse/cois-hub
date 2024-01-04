<?php

namespace App\Controller\Admin\User;

use App\Command\User\CreateUserCommand;
use App\DataTransferObjects\UserAdminDTO;
use App\Form\CreateUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('ROLE_ADMIN')]
class CreateUserController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/admin/users/new', name: 'app_admin_user_new', methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        $user = new UserAdminDTO();
        $form = $this->createForm(CreateUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $command = new CreateUserCommand(
                $user->getUsername(),
                $user->getPassword(),
                $user->getEmail(),
                $user->getRoles(),
                $user->isVerified(),
                $user->getCredentialsExpired(),
                $user->isPublic(),
            );

            try {
                $this->messageBus->dispatch($command);
                $envelope = $this->messageBus->dispatch($command);

                $handledStamp = $envelope->last(HandledStamp::class);
                $userId = $handledStamp->getResult();

                if (null !== $userId) {
                    $this->addFlash('success', $this->translator->trans('flash.user_created'));

                    return $this->redirectToRoute('app_admin_user_show', ['id' => $userId], Response::HTTP_SEE_OTHER);
                }
            } catch (HandlerFailedException) {
                $this->addFlash('danger', $this->translator->trans('flash.user_creation_failed'));
            }

            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}

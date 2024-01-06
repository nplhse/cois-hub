<?php

namespace App\Controller\Admin\User;

use App\Command\User\EditUserCommand;
use App\DataTransferObjects\UserAdminDTO;
use App\Entity\User;
use App\Form\EditUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('ROLE_ADMIN')]
class EditUserController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/admin/users/{id}/edit', name: 'app_admin_user_edit', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, User $user): Response
    {
        $userDto = new UserAdminDTO();
        $userDto->setId($user->getId());
        $userDto->setUsername($user->getUsername());
        $userDto->setEmail($user->getEmail());
        $userDto->setRoles($user->getRoles());
        $userDto->setIsVerified($user->isVerified());
        $userDto->setCredentialsExpired($user->hasCredentialsExpired());
        $userDto->setIsPublic($user->isPublic());

        $form = $this->createForm(EditUserType::class, $userDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userDto = $form->getData();

            $command = new EditUserCommand(
                $userDto->getId(),
                $userDto->getUsername(),
                $userDto->getPassword(),
                $userDto->getEmail(),
                $userDto->getRoles(),
                $userDto->isVerified(),
                $userDto->getCredentialsExpired(),
                $userDto->isPublic(),
            );

            try {
                $this->messageBus->dispatch($command);
            } catch (HandlerFailedException) {
                $this->addFlash('danger', $this->translator->trans('flash.user_edit_failed'));
            }

            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}

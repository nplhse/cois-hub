<?php

namespace App\Controller\Admin\User;

use App\Command\User\CreateUserCommand;
use App\DataTransferObjects\UserAdminDTO;
use App\Form\CreateUserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('ROLE_ADMIN')]
class CreateUserController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly TranslatorInterface $translator,
        private readonly UserRepository $userRepository,
    ) {
    }

    #[Route('/admin/users/new', name: 'app_admin_user_new', methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        $userDto = new UserAdminDTO();
        $form = $this->createForm(CreateUserType::class, $userDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UserAdminDTO $userDto */
            $userDto = $form->getData();

            $command = new CreateUserCommand(
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

                $user = $this->userRepository->findOneBy([
                    'username' => $userDto->getUsername(),
                    'email' => $userDto->getEmail(),
                ]);

                if (null !== $user) {
                    $this->addFlash('success', $this->translator->trans('flash.user_created'));

                    return $this->redirectToRoute('app_admin_user_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
                }
            } catch (HandlerFailedException) {
                $this->addFlash('danger', $this->translator->trans('flash.user_creation_failed'));
            }

            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/user/new.html.twig', [
            'user' => $userDto,
            'form' => $form,
        ]);
    }
}

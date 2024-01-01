<?php

namespace App\Controller\Security;

use App\Command\User\RegisterUserCommand;
use App\DataTransferObjects\RegisterTypeDTO;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly UserRepository $userRepository,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/register', name: 'app_register')]
    public function __invoke(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        LoginFormAuthenticator $authenticator,
    ): Response {
        $registerTypeDTO = new RegisterTypeDTO();
        $form = $this->createForm(RegistrationType::class, $registerTypeDTO);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $registerTypeDTO = $form->getData();

            $command = new RegisterUserCommand(
                $registerTypeDTO->getUsername(),
                $registerTypeDTO->getEmail(),
                $registerTypeDTO->getPassword()
            );

            try {
                $this->messageBus->dispatch($command);
                $envelope = $this->messageBus->dispatch($command);

                $handledStamp = $envelope->last(HandledStamp::class);
                $userId = $handledStamp->getResult();

                $user = $this->userRepository->findOneBy(['id' => $userId]);

                if (null === $user) {
                    $this->addFlash('warning', $this->translator->trans('flash.registration_failed'));

                    return $this->render('security/register.html.twig', [
                        'registrationForm' => $form->createView(),
                    ]);
                }

                $this->addFlash('success', $this->translator->trans('flash.user_registered'));

                return $userAuthenticator->authenticateUser(
                    $user,
                    $authenticator,
                    $request
                );
            } catch (HandlerFailedException) {
                $this->addFlash('danger', 'Sorry, something went wrong. Please try again later!');
            }
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}

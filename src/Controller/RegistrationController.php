<?php

namespace App\Controller;

use App\Command\RegisterUserCommand;
use App\DataTransferObjects\RegisterTypeDTO;
use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    public function __construct(
        private readonly EmailVerifier $emailVerifier,
        private readonly MessageBusInterface $messageBus,
        private readonly UserRepository $userRepository
    ) {
    }

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        LoginFormAuthenticator $authenticator,
        EntityManagerInterface $entityManager
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

            $envelope = $this->messageBus->dispatch($command);

            $handledStamp = $envelope->last(HandledStamp::class);
            $userId = $handledStamp->getResult();

            $user = $this->userRepository->findOneBy(['id' => $userId]);

            $this->sendEmailConfirmation($user);
            $this->addFlash('success', 'Your account has been created.');

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    private function sendEmailConfirmation(User $user): void
    {
        // generate a signed url and email it to the user
        $this->emailVerifier->sendEmailConfirmation(
            'app_verify_email',
            $user,
            (new TemplatedEmail())
                ->from(new Address('noreply@cois-hub.local', 'COIS Hub Mailer'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('emails/confirmation_email.html.twig')
        );
    }
}

<?php

namespace App\Controller;

use App\DataTransferObjects\LoginFormDTO;
use App\Entity\User;
use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $loginFormDTO = new LoginFormDTO();

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        if (!$this->getUser()) {
            $loginFormDTO->setUsername($authenticationUtils->getLastUsername());
        } else {
            /** @var User $user */
            $user = $this->getUser();
            $loginFormDTO->setUsername($user->getUsername());
        }

        $form = $this->createForm(LoginType::class, $loginFormDTO);

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): never
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}

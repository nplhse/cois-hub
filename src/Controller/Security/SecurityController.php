<?php

namespace App\Controller\Security;

use App\DataTransferObjects\LoginTypeDTO;
use App\Entity\User;
use App\Form\Security\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        $loginFormDTO = new LoginTypeDTO();
        $loginFormDTO->setUsername($this->getUserName($authenticationUtils));

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

    private function getUsername(AuthenticationUtils $authenticationUtils): string
    {
        if (!$this->getUser()) {
            return $authenticationUtils->getLastUsername();
        }

        /** @var User $user */
        $user = $this->getUser();

        return $user->getUsername();
    }
}

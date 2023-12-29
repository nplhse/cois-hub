<?php

namespace App\Controller\User;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfileController extends AbstractController
{
    #[Route('/user/profile/{id}', name: 'app_user_profile')]
    public function index(User $user): Response
    {
        if (!$user->isPublic()) {
            $this->denyAccessUnlessGranted('ROLE_USER');
        }

        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }
}

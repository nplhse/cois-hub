<?php

namespace App\Controller\User;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

class ListUsersController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    #[Route('/user/', name: 'app_user')]
    public function index(
        #[MapQueryParameter]
        int $page = 1,
    ): Response {
        if ($this->isGranted('ROLE_USER')) {
            $users = $this->userRepository->getPaginatedResults($page, 16);
            $userCount = $this->userRepository->getUserCount();
        }

        if (!isset($users)) {
            $users = $this->userRepository->getPublicPaginatedResults($page, 16);
        }

        if (!isset($userCount)) {
            $userCount = $this->userRepository->getUserCount(true);
        }

        return $this->render('user/list.html.twig', [
            'user_count' => $userCount,
            'users' => $users,
        ]);
    }
}

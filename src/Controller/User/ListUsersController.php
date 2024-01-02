<?php

namespace App\Controller\User;

use App\Query\UserListQuery;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

class ListUsersController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserListQuery $query
    ) {
    }

    #[Route('/user/', name: 'app_user')]
    public function __invoke(
        #[MapQueryParameter]
        int $page = 1,
        #[MapQueryParameter]
        string $search = '',
    ): Response {
        if ($this->isGranted('ROLE_USER')) {
            $users = $this->query->getResults($page, 16, 'username', 'asc', $search);
            $userCount = $this->query->countResults('username', $search);
        }

        if (!isset($users)) {
            $users = $this->query->onlyPublicUsers()->getResults($page, 16, 'username', 'asc', $search);
        }

        if (!isset($userCount)) {
            $userCount = $this->query->onlyPublicUsers()->countResults('username', $search);
        }

        return $this->render('user/list.html.twig', [
            'user_count' => $userCount,
            'users' => $users,
        ]);
    }
}

<?php

namespace App\Controller\Admin\User;

use App\Query\UserListQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class ListUsersController extends AbstractController
{
    public function __construct(
        private readonly UserListQuery $query,
    ) {
    }

    #[Route('/admin/users', name: 'app_admin_user_index', methods: ['GET'])]
    public function index(
        #[MapQueryParameter]
        int $page = 1,
        #[MapQueryParameter]
        string $search = '',
        #[MapQueryParameter]
        string $sortBy = 'username',
        #[MapQueryParameter]
        string $orderBy = 'asc',
    ): Response {
        $users = $this->query->getResults($page, 16, $sortBy, $orderBy, $search);

        return $this->render('admin/user/list.html.twig', [
            'users' => $users,
            'sortBy' => $sortBy,
            'orderBy' => $orderBy,
        ]);
    }
}

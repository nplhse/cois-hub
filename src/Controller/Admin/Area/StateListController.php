<?php

namespace App\Controller\Admin\Area;

use App\Query\AreaStateListQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class StateListController extends AbstractController
{
    public function __construct(
        private AreaStateListQuery $query
    ) {
    }

    #[Route('/admin/area/state', name: 'app_admin_area_state_index', methods: ['GET'])]
    public function __invoke(
        #[MapQueryParameter]
        int $page = 1,
        #[MapQueryParameter]
        string $search = '',
        #[MapQueryParameter]
        string $sortBy = 'name',
        #[MapQueryParameter]
        string $orderBy = 'asc',
    ): Response {
        $states = $this->query->getResults($page, 10, $sortBy, $orderBy, $search);

        return $this->render('admin/area/state/list.html.twig', [
            'states' => $states,
            'sortBy' => $sortBy,
            'orderBy' => $orderBy,
        ]);
    }
}

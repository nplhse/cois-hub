<?php

namespace App\Controller\Admin\Area;

use App\Query\AreaDispatchListQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class DispatchAreaListController extends AbstractController
{
    public function __construct(
        private AreaDispatchListQuery $query
    ) {
    }

    #[Route('/admin/area/dispatch', name: 'app_admin_area_dispatch_index', methods: ['GET'])]
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
        $dispatchArea = $this->query->getResults($page, 10, $sortBy, $orderBy, $search);

        return $this->render('admin/area/dispatch_area/list.html.twig', [
            'dispatch_areas' => $dispatchArea,
            'sortBy' => $sortBy,
            'orderBy' => $orderBy,
        ]);
    }
}

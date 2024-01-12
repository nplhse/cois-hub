<?php

namespace App\Controller\Admin\Area;

use App\Query\AreaSupplyListQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class SupplyAreaListController extends AbstractController
{
    public function __construct(
        private readonly AreaSupplyListQuery $query
    ) {
    }

    #[Route('/admin/area/supply/', name: 'app_admin_area_supply_index', methods: ['GET'])]
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
        $supplyAreas = $this->query->getResults($page, 10, $sortBy, $orderBy, $search);

        return $this->render('admin/area/supply_area/list.html.twig', [
            'supply_areas' => $supplyAreas,
            'sortBy' => $sortBy,
            'orderBy' => $orderBy,
        ]);
    }
}

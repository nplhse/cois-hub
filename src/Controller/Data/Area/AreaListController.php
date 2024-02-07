<?php

namespace App\Controller\Data\Area;

use App\Query\ListAreasQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class AreaListController extends AbstractController
{
    public function __construct(
        private readonly ListAreasQuery $query,
    ) {
    }

    #[Route('/data/area/', name: 'app_data_area_index')]
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
        $paginator = $this->query->getResults($page, 20, $sortBy, $orderBy, $search);

        return $this->render('data/area/list.html.twig', [
            'paginator' => $paginator,
            'sortBy' => $sortBy,
            'orderBy' => $orderBy,
        ]);
    }
}

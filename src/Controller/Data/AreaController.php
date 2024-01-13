<?php

namespace App\Controller\Data;

use App\Query\ListAreasQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Routing\Annotation\Route;

class AreaController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        private readonly ListAreasQuery $query,
    ) {
    }

    #[Route('/data/area', name: 'app_data_area')]
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
        $areas = $this->query->getResults($page, 20, $sortBy, $orderBy, $search);

        return $this->render('data/area/index.html.twig', [
            'areas' => $areas,
            'sortBy' => $sortBy,
            'orderBy' => $orderBy,
        ]);
    }
}

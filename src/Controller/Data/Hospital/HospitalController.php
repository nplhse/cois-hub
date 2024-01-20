<?php

namespace App\Controller\Data\Hospital;

use App\Query\ListHospitalsQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

class HospitalController extends AbstractController
{
    public function __construct(
        private readonly ListHospitalsQuery $query,
    ) {
    }

    #[Route('/data/hospital/', name: 'app_data_hospital_index')]
    public function index(
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

        return $this->render('data/hospital/index.html.twig', [
            'hospitals' => $areas,
            'sortBy' => $sortBy,
            'orderBy' => $orderBy,
        ]);
    }
}

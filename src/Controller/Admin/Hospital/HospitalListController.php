<?php

namespace App\Controller\Admin\Hospital;

use App\Query\ListHospitalsQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class HospitalListController extends AbstractController
{
    public function __construct(
        private readonly ListHospitalsQuery $query
    ) {
    }

    #[Route('/admin/hospital', name: 'app_admin_hospital_index', methods: ['GET'])]
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
        $hospitals = $this->query->getResults($page, 10, $sortBy, $orderBy, $search);

        return $this->render('admin/hospital/list.html.twig', [
            'paginator' => $hospitals,
            'sortBy' => $sortBy,
            'orderBy' => $orderBy,
        ]);
    }
}

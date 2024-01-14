<?php

namespace App\Controller\Admin\Area\SupplyArea;

use App\Entity\SupplyArea;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class SupplyAreaShowController extends AbstractController
{
    #[Route('/admin/area/supply/{id}', name: 'app_admin_area_supply_show', methods: ['GET'])]
    public function __invoke(SupplyArea $supplyArea): Response
    {
        return $this->render('admin/area/supply_area/show.html.twig', [
            'supply_area' => $supplyArea,
        ]);
    }
}

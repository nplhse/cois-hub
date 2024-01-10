<?php

namespace App\Controller\Admin\Area;

use App\Entity\SupplyArea;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class SupplyAreaDeleteController extends AbstractController
{
    #[Route('/admin/area/supply/{id}', name: 'app_admin_area_supply_delete', methods: ['POST'])]
    public function __invoke(Request $request, SupplyArea $supplyArea, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$supplyArea->getId(), $request->request->get('_token'))) {
            $entityManager->remove($supplyArea);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_area_supply_index', [], Response::HTTP_SEE_OTHER);
    }
}

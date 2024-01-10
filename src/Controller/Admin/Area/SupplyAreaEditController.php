<?php

namespace App\Controller\Admin\Area;

use App\Entity\SupplyArea;
use App\Form\SupplyAreaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class SupplyAreaEditController extends AbstractController
{
    #[Route('/admin/area/supply/{id}/edit', name: 'app_admin_area_supply_edit', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, SupplyArea $supplyArea, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SupplyAreaType::class, $supplyArea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_area_supply_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/area/supply_area/edit.html.twig', [
            'supply_area' => $supplyArea,
            'form' => $form,
        ]);
    }
}

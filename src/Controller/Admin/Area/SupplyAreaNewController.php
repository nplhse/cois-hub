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
class SupplyAreaNewController extends AbstractController
{
    #[Route('/admin/area/supply/new', name: 'app_admin_area_supply_new', priority: 100, methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $supplyArea = new SupplyArea();
        $form = $this->createForm(SupplyAreaType::class, $supplyArea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($supplyArea);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_area_supply_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/area/supply_area/new.html.twig', [
            'supply_area' => $supplyArea,
            'form' => $form,
        ]);
    }
}

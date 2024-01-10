<?php

namespace App\Controller\Admin\Data;

use App\Entity\SupplyArea;
use App\Form\SupplyAreaType;
use App\Repository\SupplyAreaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/area/supply')]
class SupplyAreaController extends AbstractController
{
    #[Route('/', name: 'app_admin_area_supply_index', methods: ['GET'])]
    public function index(SupplyAreaRepository $supplyAreaRepository): Response
    {
        return $this->render('admin/area/supply_area/index.html.twig', [
            'supply_areas' => $supplyAreaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_area_supply_new', methods: ['GET', 'POST'])]
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

    #[Route('/{id}', name: 'app_admin_area_supply_show', methods: ['GET'])]
    public function show(SupplyArea $supplyArea): Response
    {
        return $this->render('admin/area/supply_area/show.html.twig', [
            'supply_area' => $supplyArea,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_area_supply_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SupplyArea $supplyArea, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SupplyAreaType::class, $supplyArea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($supplyArea);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_area_supply_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/area/supply_area/edit.html.twig', [
            'supply_area' => $supplyArea,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_area_supply_delete', methods: ['POST'])]
    public function delete(Request $request, SupplyArea $supplyArea, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$supplyArea->getId(), $request->request->get('_token'))) {
            $entityManager->remove($supplyArea);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_area_supply_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller\Admin\Data;

use App\Entity\DispatchArea;
use App\Form\DispatchAreaType;
use App\Repository\DispatchAreaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/area/dispatch')]
class DispatchAreaController extends AbstractController
{
    #[Route('/', name: 'app_admin_area_dispatch_index', methods: ['GET'])]
    public function index(DispatchAreaRepository $dispatchAreaRepository): Response
    {
        return $this->render('admin/area/dispatch_area/index.html.twig', [
            'dispatch_areas' => $dispatchAreaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_area_dispatch_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dispatchArea = new DispatchArea();
        $form = $this->createForm(DispatchAreaType::class, $dispatchArea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dispatchArea);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_area_dispatch_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/area/dispatch_area/new.html.twig', [
            'dispatch_area' => $dispatchArea,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_area_dispatch_show', methods: ['GET'])]
    public function show(DispatchArea $dispatchArea): Response
    {
        return $this->render('admin/area/dispatch_area/show.html.twig', [
            'dispatch_area' => $dispatchArea,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_area_dispatch_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DispatchArea $dispatchArea, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DispatchAreaType::class, $dispatchArea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_area_dispatch_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/area/dispatch_area/edit.html.twig', [
            'dispatch_area' => $dispatchArea,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_area_dispatch_delete', methods: ['POST'])]
    public function delete(Request $request, DispatchArea $dispatchArea, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dispatchArea->getId(), $request->request->get('_token'))) {
            $entityManager->remove($dispatchArea);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_area_dispatch_index', [], Response::HTTP_SEE_OTHER);
    }
}

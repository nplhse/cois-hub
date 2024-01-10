<?php

namespace App\Controller\Admin\Data;

use App\Entity\State;
use App\Form\StateType;
use App\Repository\StateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/area/state')]
class StateController extends AbstractController
{
    #[Route('/', name: 'app_admin_area_state_index', methods: ['GET'])]
    public function index(StateRepository $stateRepository): Response
    {
        return $this->render('admin/area/state/index.html.twig', [
            'states' => $stateRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_area_state_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $state = new State();
        $form = $this->createForm(StateType::class, $state);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($state);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_area_state_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/area/state/new.html.twig', [
            'state' => $state,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_area_state_show', methods: ['GET'])]
    public function show(State $state): Response
    {
        return $this->render('admin/area/state/show.html.twig', [
            'state' => $state,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_area_state_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, State $state, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StateType::class, $state);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_area_state_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/area/state/edit.html.twig', [
            'state' => $state,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_area_state_delete', methods: ['POST'])]
    public function delete(Request $request, State $state, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$state->getId(), $request->request->get('_token'))) {
            $entityManager->remove($state);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_area_state_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller\Admin\Area;

use App\Entity\State;
use App\Form\StateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class StateEditController extends AbstractController
{
    #[Route('/admin/area/state/{id}/edit', name: 'app_admin_area_state_edit', methods: ['GET', 'POST'])]
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
}

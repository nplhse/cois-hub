<?php

namespace App\Controller\Admin\Area;

use App\Entity\State;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class StateDeleteController extends AbstractController
{
    #[Route('/admin/area/state/{id}', name: 'app_admin_area_state_delete', methods: ['POST'])]
    public function delete(Request $request, State $state, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$state->getId(), $request->request->get('_token'))) {
            $entityManager->remove($state);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_area_state_index', [], Response::HTTP_SEE_OTHER);
    }
}

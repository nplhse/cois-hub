<?php

namespace App\Controller\Admin\Area\State;

use App\Entity\State;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class StateShowController extends AbstractController
{
    #[Route('/admin/area/state/{id}', name: 'app_admin_area_state_show', methods: ['GET'])]
    public function __invoke(State $state): Response
    {
        return $this->render('admin/area/state/show.html.twig', [
            'state' => $state,
        ]);
    }
}

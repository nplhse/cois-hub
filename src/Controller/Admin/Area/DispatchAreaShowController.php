<?php

namespace App\Controller\Admin\Area;

use App\Entity\DispatchArea;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class DispatchAreaShowController extends AbstractController
{
    #[Route('/admin/area/dispatch/{id}', name: 'app_admin_area_dispatch_show', methods: ['GET'])]
    public function show(DispatchArea $dispatchArea): Response
    {
        return $this->render('admin/area/dispatch_area/show.html.twig', [
            'dispatch_area' => $dispatchArea,
        ]);
    }
}

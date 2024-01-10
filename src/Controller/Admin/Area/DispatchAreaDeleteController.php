<?php

namespace App\Controller\Admin\Area;

use App\Entity\DispatchArea;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class DispatchAreaDeleteController extends AbstractController
{
    #[Route('/admin/area/dispatch/{id}', name: 'app_admin_area_dispatch_delete', methods: ['POST'])]
    public function __invoke(Request $request, DispatchArea $dispatchArea, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dispatchArea->getId(), $request->request->get('_token'))) {
            $entityManager->remove($dispatchArea);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_area_dispatch_index', [], Response::HTTP_SEE_OTHER);
    }
}

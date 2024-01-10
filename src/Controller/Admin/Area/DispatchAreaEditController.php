<?php

namespace App\Controller\Admin\Area;

use App\Entity\DispatchArea;
use App\Form\DispatchAreaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class DispatchAreaEditController extends AbstractController
{
    #[Route('/admin/area/dispatch/{id}/edit', name: 'app_admin_area_dispatch_edit', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, DispatchArea $dispatchArea, EntityManagerInterface $entityManager): Response
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
}

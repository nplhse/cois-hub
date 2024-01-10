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
class DispatchAreaNewController extends AbstractController
{
    #[Route('/admin/area/dispatch/new', name: 'app_admin_area_dispatch_new', priority: 100, methods: ['GET', 'POST'])]
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
}

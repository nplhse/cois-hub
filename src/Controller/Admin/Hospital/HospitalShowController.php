<?php

namespace App\Controller\Admin\Hospital;

use App\Entity\Hospital;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class HospitalShowController extends AbstractController
{
    #[Route('/admin/hospital/{id}', name: 'app_admin_hospital_show', methods: ['GET'])]
    public function __invoke(Hospital $hospital): Response
    {
        return $this->render('admin/hospital/show.html.twig', [
            'hospital' => $hospital,
        ]);
    }
}

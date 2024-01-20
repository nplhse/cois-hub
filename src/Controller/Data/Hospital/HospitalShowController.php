<?php

namespace App\Controller\Data\Hospital;

use App\Entity\Hospital;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HospitalShowController extends AbstractController
{
    #[Route('/data/hospital/{id}', name: 'app_data_hospital_show')]
    public function index(Hospital $hospital): Response
    {
        return $this->render('data/hospital/show.html.twig', [
            'hospital' => $hospital,
        ]);
    }
}

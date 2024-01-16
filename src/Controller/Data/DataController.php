<?php

namespace App\Controller\Data;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends AbstractController
{
    #[Route('/data/', name: 'app_data_index')]
    public function __invoke(): Response
    {
        return $this->redirectToRoute('app_data_hospital_index');
    }
}

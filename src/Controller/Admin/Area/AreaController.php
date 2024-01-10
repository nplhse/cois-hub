<?php

namespace App\Controller\Admin\Area;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AreaController extends AbstractController
{
    #[Route('/admin/area/', name: 'app_admin_area')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_admin_area_dispatch_index');
    }
}

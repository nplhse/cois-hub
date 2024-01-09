<?php

namespace App\Controller\Admin\System\AuditLog;

use App\Entity\AuditLog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class AuditLogDetailController extends AbstractController
{
    #[Route('/admin/system/audit_log/{id}', name: 'app_admin_system_auditlog_detail')]
    public function index(AuditLog $auditLog): Response
    {
        return $this->render('admin/system/audit_log/detail.html.twig', [
            'audit_log' => $auditLog,
        ]);
    }
}

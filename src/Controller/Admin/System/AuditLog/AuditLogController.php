<?php

namespace App\Controller\Admin\System\AuditLog;

use App\Pagination\Paginator;
use App\Query\AuditLogQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class AuditLogController extends AbstractController
{
    public function __construct(
        private readonly AuditLogQuery $query
    ) {
    }

    #[Route('/admin/system/audit_log', name: 'app_admin_system_auditlog')]
    public function index(
        #[MapQueryParameter]
        int $page = 1
    ): Response {
        /** @var Paginator $auditLogs */
        $auditLogs = $this->query->execute($page);

        return $this->render('admin/system/audit_log/list.html.twig', [
            'audit_logs' => $auditLogs,
        ]);
    }
}

<?php

namespace App\Controller\Admin;

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

    #[Route('/admin/auditlog', name: 'app_admin_auditlog_index')]
    public function index(
        #[MapQueryParameter]
        int $page = 1
    ): Response {
        /** @var Paginator $auditLogs */
        $auditLogs = $this->query->execute($page);

        return $this->render('admin/auditlog/index.html.twig', [
            'audit_logs' => $auditLogs,
        ]);
    }
}

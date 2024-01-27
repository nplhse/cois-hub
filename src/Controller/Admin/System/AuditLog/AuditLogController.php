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
        int $page = 1,
        #[MapQueryParameter]
        string $search = '',
        #[MapQueryParameter]
        string $sortBy = 'id',
        #[MapQueryParameter]
        string $orderBy = 'asc',
    ): Response {
        /** @var Paginator $paginator */
        $paginator = $this->query->execute($page, 10);

        return $this->render('admin/system/audit_log/list.html.twig', [
            'paginator' => $paginator,
            'sortBy' => $sortBy,
            'orderBy' => $orderBy,
        ]);
    }
}

<?php

namespace App\Query;

use App\Repository\AuditLogRepository;

class AuditLogQuery
{
    public function __construct(
        private readonly AuditLogRepository $auditLogRepository,
    ) {
    }

    public function execute(int $page = 1, int $perPage = 25): \App\Pagination\Paginator
    {
        return $this->auditLogRepository->getPaginatedResults($page, $perPage);
    }
}

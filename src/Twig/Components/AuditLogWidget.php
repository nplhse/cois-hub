<?php

namespace App\Twig\Components;

use App\Pagination\Paginator;
use App\Query\AuditLogQuery;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final readonly class AuditLogWidget
{
    public function __construct(
        private AuditLogQuery $query
    ) {
    }

    public function getLatestLogs(): Paginator
    {
        return $this->query->execute(1, 5);
    }
}

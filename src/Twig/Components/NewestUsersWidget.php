<?php

namespace App\Twig\Components;

use App\Pagination\Paginator;
use App\Query\UserListQuery;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final readonly class NewestUsersWidget
{
    public function __construct(
        private UserListQuery $query
    ) {
    }

    public function getUsers(): Paginator
    {
        return $this->query->getResults(1, 10, 'createdAt', 'desc');
    }
}

<?php

namespace App\Twig\Components;

use App\Query\UserCountQuery;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final readonly class UserCountWidget
{
    public function __construct(
        private UserCountQuery $query,
    ) {
    }

    public function getAllUsers(): int
    {
        return $this->query->countAllUsers();
    }
}

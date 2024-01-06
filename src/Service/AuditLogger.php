<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\AuditLog;
use App\Entity\User;
use App\Enum\AuditActions;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class AuditLogger
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly Security $security,
        private readonly RequestStack $requestStack,
    ) {
    }

    /**
     * @param array|string[] $eventData
     */
    public function log(string $entityType, int $entityId, AuditActions $action, array $eventData): void
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $request = $this->requestStack->getCurrentRequest();

        $log = new AuditLog(
            $entityType,
            $entityId,
            new \DateTimeImmutable(),
            $this->getRouteFromRequest($request),
            $eventData,
            $action->getType(),
            $this->getClientIpFromRequest($request),
            $user
        );

        $this->em->persist($log);
        $this->em->flush();
    }

    private function getClientIpFromRequest(?Request $request): ?string
    {
        if (null === $request) {
            return null;
        }

        return (string) $request->getClientIp();
    }

    private function getRouteFromRequest(?Request $request): string
    {
        if (null === $request) {
            return 'console';
        }

        return (string) $request->attributes->get('_route');
    }
}

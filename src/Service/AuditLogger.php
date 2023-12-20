<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\AuditLog;
use App\Entity\User;
use App\Enum\AuditActions;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;

class AuditLogger
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly Security $security,
        private readonly RequestStack $requestStack
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

        if (null === $request) {
            return;
        }

        $log = new AuditLog(
            $entityType,
            $entityId,
            new \DateTimeImmutable(),
            $request->attributes->get('_route'),
            $eventData,
            $action->getType(),
            $request->getClientIp(),
            $user
        );

        $this->em->persist($log);
        $this->em->flush();
    }
}

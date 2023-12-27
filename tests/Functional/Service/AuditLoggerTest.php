<?php

namespace App\Tests\Functional\Service;

use App\Enum\AuditActions;
use App\Factory\UserFactory;
use App\Repository\AuditLogRepository;
use App\Service\AuditLogger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\SecurityBundle\Security;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class AuditLoggerTest extends KernelTestCase
{
    use ResetDatabase;
    use Factories;

    public function testItLogsAEntityToTheDatabase(): void
    {
        $kernel = self::bootKernel();

        // 1. "Arrange"
        $user = UserFactory::new(['username' => 'foo'])->create();

        $security = $this->createMock(Security::class);
        $security->expects($this->once())
            ->method('getUser')->willReturn($user->object());
        self::getContainer()->set(Security::class, $security);

        // 2. "Act"
        /** @var AuditLogger $auditLogger */
        $auditLogger = self::getContainer()->get(AuditLogger::class);
        $auditLogger->log(
            'User',
            $user->getId(),
            AuditActions::INSERT,
            ['test' => 'test']
        );

        $auditLogRepository = self::getContainer()->get(AuditLogRepository::class);
        $auditLog = $auditLogRepository->findOneBy(['id' => 1]);

        $this->assertSame('User', $auditLog->getEntityType());
        $this->assertSame($user->getId(), $auditLog->getId());
        $this->assertSame('console', $auditLog->getRequestRoute());
        $this->assertSame(AuditActions::INSERT->value, $auditLog->getAction());
        $this->assertSame(['test' => 'test'], $auditLog->getEventData());
        $this->assertNull($auditLog->getIpAddress());
    }
}

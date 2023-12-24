<?php

namespace App\Tests\Integration\Entity;

use App\Entity\AuditLog;
use App\Enum\AuditActions;
use App\Factory\UserFactory;
use App\Repository\AuditLogRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class AuditLogTest extends KernelTestCase
{
    use ResetDatabase;
    use Factories;

    public function testSomething(): void
    {
        // 1. "Arrange"
        $user = UserFactory::new(['username' => 'foo'])->create();
        $createdAt = \DateTimeImmutable::createFromFormat('d.m.Y H:i:s', '01.01.2021 08:15:00');

        static::ensureKernelShutdown();
        $kernel = self::bootKernel();

        // 2. "Act"
        $auditLogRepository = self::getContainer()->get(AuditLogRepository::class);

        $auditLog = new AuditLog(
            'AuditLog',
            123,
            $createdAt,
            'app_test_route',
            ['test' => 'test'],
            AuditActions::INSERT->value,
            '127.0.0.1',
            $user->object()
        );

        $auditLogRepository->save($auditLog, true);

        // 3. "Assert"
        $auditLog = $auditLogRepository->findOneBy([
            'id' => 1,
        ]);

        $this->assertSame('AuditLog', $auditLog->getEntityType());
        $this->assertSame(123, $auditLog->getEntityId());
        $this->assertSame($createdAt, $auditLog->getCreatedAt());
        $this->assertSame('app_test_route', $auditLog->getRequestRoute());
        $this->assertSame(['test' => 'test'], $auditLog->getEventData());
        $this->assertSame(AuditActions::INSERT->value, $auditLog->getAction());
        $this->assertSame('127.0.0.1', $auditLog->getIpAddress());
        $this->assertSame($user->getUsername(), $auditLog->getUser()->getUsername());
    }
}

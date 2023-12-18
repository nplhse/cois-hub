<?php

namespace App\Tests\Entity;

use App\Entity\AuditLog;
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
        $kernel = self::bootKernel();
        $auditLogRepository = self::getContainer()->get(AuditLogRepository::class);

        $createdAt = \DateTimeImmutable::createFromFormat('d.m.Y H:i:s', '01.01.2021 08:15:00');

        $auditLog = new AuditLog(
            'AuditLog',
            123,
            $createdAt,
            'app_test_route',
            'test',
            '127.0.0.1',
        );

        $auditLogRepository->save($auditLog, true);

        $auditLog = $auditLogRepository->findOneBy([
            'id' => 1,
        ]);

        $this->assertSame('AuditLog', $auditLog->getEntityType());
        $this->assertSame(123, $auditLog->getEntityId());
        $this->assertSame($createdAt, $auditLog->getCreatedAt());
        $this->assertSame('test', $auditLog->getAction());
        $this->assertSame('app_test_route', $auditLog->getRequestRoute());
        $this->assertSame('127.0.0.1', $auditLog->getIpAddress());
    }
}

<?php

namespace App\Tests\src\Command;

use App\Command\OmnivaSynchroniseDatabaseCommand;
use App\Entity\DatabaseSynchronisation;
use App\Entity\Omniva;
use App\Service\SynchroniseDatabaseCommandService;
use App\Tests\CustomWebTestCase;
use Exception;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class OmnivaSynchroniseDatabaseCommandTest extends CustomWebTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
        $this->truncateEntities();
    }

    public function testSynchroniseDatabaseSuccess(): void
    {
        $commandTester = $this->synchroniseDatabaseExecuteCommand();

        // Assertion
        self::assertSame(0, $commandTester->getStatusCode());
        self::assertCount(4, $this->getEntityManager()->getRepository(Omniva::class)->findAll());
        self::assertSame('status-success', $this->getEntityManager()
            ->getRepository(DatabaseSynchronisation::class)->findAll()[0]->getStatus());
    }

    public function testSynchroniseDatabaseError(): void
    {
        $commandTester = $this->synchroniseDatabaseExecuteCommand(true);

        // Assertion
        self::assertSame(1, $commandTester->getStatusCode());
        self::assertCount(0, $this->getEntityManager()->getRepository(Omniva::class)->findAll());
        self::assertSame('status-error', $this->getEntityManager()
            ->getRepository(DatabaseSynchronisation::class)->findAll()[0]->getStatus());
        self::assertSame('error', $this->getEntityManager()
            ->getRepository(DatabaseSynchronisation::class)->findAll()[0]->getErrorMessage());
    }

    public function synchroniseDatabaseExecuteCommand(bool $isError = false): CommandTester
    {
        $synchroniseDatabaseService = $this->createMock(SynchroniseDatabaseCommandService::class);
        $content = json_decode(
            file_get_contents(__DIR__ . '/../../document/postMachines.json'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        if ($isError) {
            $synchroniseDatabaseService->method('fetchPostMachines')
                ->will($this->throwException(new Exception('error')));
        } else {
            $synchroniseDatabaseService->method('fetchPostMachines')->willReturn($content);
        }

        $application = new Application(self::$kernel);
        $application->add(new OmnivaSynchroniseDatabaseCommand(
            $synchroniseDatabaseService,
            $this->getEntityManager()->getRepository(Omniva::class),
            $this->getEntityManager()
        ));

        $command = $application->find('omniva:synchronise-database');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        return $commandTester;
    }
}

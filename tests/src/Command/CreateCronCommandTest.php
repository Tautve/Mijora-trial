<?php

namespace App\Tests\src\Command;

use App\Tests\CustomWebTestCase;
use Cron\CronBundle\Entity\CronJob;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class CreateCronCommandTest extends CustomWebTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
        $this->truncateEntities();
    }

    public function testCreateCronCommand(): void
    {
        $application = new Application(self::$kernel);

        $command = $application->find('omniva:create-cron');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        self::assertEquals(0, $commandTester->getStatusCode());
        self::assertCount(1, $this->getEntityManager()->getRepository(CronJob::class)->findAll());
    }
}

<?php

namespace App\Command;

use Cron\CronBundle\Entity\CronJob;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'omniva:create-cron',
    description: 'Create crons',
)]
class CreateCronCommand extends Command
{
    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Creating crons');

        $cron = [
                'name' => 'DatabaseSynchronisation',
                'command' => 'omniva:synchronise-database',
                'schedule' => '30 22 * * *',
                'description' => 'Synchronise database with external omniva post machines list',
                'enabled' => 1
        ];

            $commands = $this->em->getRepository(CronJob::class)->findBy([
                'command' => $cron['command'],
            ]);

        if (count($commands) === 0) {
            $command = (new CronJob())
                ->setName($cron['name'])
                ->setCommand($cron['command'])
                ->setSchedule($cron['schedule'])
                ->setDescription($cron['description'])
                ->setEnabled($cron['enabled']);

            $this->em->persist($command);
            $this->em->flush();
        }

        $output->writeln('Done!');

        return Command::SUCCESS;
    }
}

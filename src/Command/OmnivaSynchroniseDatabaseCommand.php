<?php

namespace App\Command;

use App\Entity\DatabaseSynchronisation;
use App\Entity\Omniva;
use App\Repository\OmnivaRepository;
use App\Service\SynchroniseDatabaseCommandService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'omniva:synchronise-database',
    description: 'Synchronise database daily',
)]
class OmnivaSynchroniseDatabaseCommand extends Command
{
    public function __construct(
        private SynchroniseDatabaseCommandService $databaseCommandService,
        private OmnivaRepository $omnivaRepository,
        private EntityManagerInterface $em
    ) {
        parent::__construct();
    }

    public function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $output->writeln('Synchronising database');

        $databaseSynchronisation = new DatabaseSynchronisation();

        try {
            $postMachines = $this->databaseCommandService->fetchPostMachines();
            if (!empty($postMachines)) {
                $this->omnivaRepository->deleteOldPostMachinesData();
                $this->savePostMachinesToDatabase($postMachines);
            }
        } catch (
            Exception $e
        ) {
            $this->saveDatabaseSynchronisation(
                $databaseSynchronisation,
                $e->getMessage()
            );

            return Command::FAILURE;
        }

        $this->saveDatabaseSynchronisation($databaseSynchronisation);

        $output->writeln('Database successfully synchronised!');

        return Command::SUCCESS;
    }

    private function savePostMachinesToDatabase(array $postMachines): void
    {
        foreach ($postMachines as $retrievedOmnivaMachine) {
            $omniva = new Omniva();
            $omniva->setZipCode($retrievedOmnivaMachine['ZIP'] ?? null);
            $omniva->setName($retrievedOmnivaMachine['NAME'] ?? null);
            $omniva->setType($retrievedOmnivaMachine['TYPE'] ?? null);
            $omniva->setA0Name($retrievedOmnivaMachine['A0_NAME'] ?? null);
            $omniva->setA1Name($retrievedOmnivaMachine['A1_NAME'] ?? null);
            $omniva->setA2Name($retrievedOmnivaMachine['A2_NAME'] ?? null);
            $omniva->setA3Name($retrievedOmnivaMachine['A3_NAME'] ?? null);
            $omniva->setA4Name($retrievedOmnivaMachine['A4_NAME'] ?? null);
            $omniva->setA5Name($retrievedOmnivaMachine['A5_NAME'] ?? null);
            $omniva->setA6Name($retrievedOmnivaMachine['A6_NAME'] ?? null);
            $omniva->setA7Name($retrievedOmnivaMachine['A7_NAME'] ?? null);
            $omniva->setA8Name($retrievedOmnivaMachine['A8_NAME'] ?? null);
            $omniva->setXCoordinate($retrievedOmnivaMachine['X_COORDINATE'] ?? null);
            $omniva->setYCoordinate($retrievedOmnivaMachine['Y_COORDINATE'] ?? null);
            $omniva->setServiceHours($retrievedOmnivaMachine['SERVICE_HOURS'] ?? null);
            $omniva->setTempServiceHours($retrievedOmnivaMachine['TEMP_SERVICE_HOURS'] ?? null);
            $omniva->setTempServiceHoursUntil($retrievedOmnivaMachine['TEMP_SERVICE_HOURS_UNTIL'] ?? null);
            $omniva->setTempServiceHours2($retrievedOmnivaMachine['TEMP_SERVICE_HOURS_2'] ?? null);
            $omniva->setTempServiceHours2Until($retrievedOmnivaMachine['TEMP_SERVICE_HOURS_2_UNTIL'] ?? null);
            $omniva->setCommentEst($retrievedOmnivaMachine['comment_est'] ?? null);
            $omniva->setCommentEng($retrievedOmnivaMachine['comment_eng'] ?? null);
            $omniva->setCommentRus($retrievedOmnivaMachine['comment_rus'] ?? null);
            $omniva->setCommentLav($retrievedOmnivaMachine['comment_lav'] ?? null);
            $omniva->setCommentLit($retrievedOmnivaMachine['comment_lit'] ?? null);
            $omniva->setModified(new DateTime($retrievedOmnivaMachine['MODIFIED']) ?? null);

            $this->em->persist($omniva);
        }
        $this->em->flush();
    }

    private function saveDatabaseSynchronisation(
        DatabaseSynchronisation $databaseSynchronisation,
        string $errorMessage = null
    ): void {
        $databaseSynchronisation->setStatus($errorMessage ?
            DatabaseSynchronisation::STATUS_ERROR :
            DatabaseSynchronisation::STATUS_SUCCESS);
        $databaseSynchronisation->setDate();
        $databaseSynchronisation->setErrorMessage($errorMessage);

        $this->em->persist($databaseSynchronisation);
        $this->em->flush();
    }
}

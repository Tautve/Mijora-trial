<?php

namespace App\Command;

use App\Entity\DatabaseSynchronisation;
use App\Repository\OmnivaRepository;
use App\Service\GeneralFunctionsService;
use App\Service\SynchroniseDatabaseCommandService;
use Exception;
use JsonException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsCommand(
    name: 'omniva:synchronise-database',
    description: 'Synchronise database daily',
)]
class OmnivaSynchroniseDatabaseCommand extends Command
{
    public function __construct(
        private SynchroniseDatabaseCommandService $databaseCommandService,
        private OmnivaRepository $omnivaRepository,
        private GeneralFunctionsService $generalFunctionsService
    ) {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $output->writeln('Synchronising database');

        $databaseSynchronisation = new DatabaseSynchronisation();

        try {
            $decodedContent = $this->databaseCommandService->fetchPostMachines();
        } catch (JsonException |
        ClientExceptionInterface |
        RedirectionExceptionInterface |
        ServerExceptionInterface |
        TransportExceptionInterface $e) {
            $this->setDatabaseSynchronisation($databaseSynchronisation, true,
                $e->getMessage());

            return Command::FAILURE;
        }

        if (!empty($decodedContent)) {
            try{
                $this->omnivaRepository->deleteOldPostMachinesData();
                $this->databaseCommandService->savePostMachinesToDatabase($decodedContent);
            } catch (Exception $e) {
                $this->setDatabaseSynchronisation($databaseSynchronisation, true,
                    $e->getMessage());

                return Command::FAILURE;
            }
        }

        $this->setDatabaseSynchronisation($databaseSynchronisation);

        $output->writeln('Database successfully synchronised!');

        return Command::SUCCESS;
    }

    private function setDatabaseSynchronisation(
        DatabaseSynchronisation $databaseSynchronisation,
        bool $isError = false,
        string $errorMessage = null
    ): void {
        $databaseSynchronisation->setStatus($isError ?
            DatabaseSynchronisation::STATUS_ERROR :
            DatabaseSynchronisation::STATUS_SUCCESS);
        $databaseSynchronisation->setDate();
        $databaseSynchronisation->setErrorMessage($errorMessage);
        $this->generalFunctionsService->persistAndFlush($databaseSynchronisation);
    }
}

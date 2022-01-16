<?php

namespace App\Service;

use App\Repository\OmnivaRepository;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class OmnivaService
{

    public function __construct(private OmnivaRepository $omnivaRepository)
    {
    }

    public function createFullAddress(array $postMachines): array
    {
        $postMachinesWithFullAddress = [];
        foreach ($postMachines as $postMachineKey => $postMachine) {
            $fulAddress = [];
            foreach ($postMachine as $postMachineDataKey => $postMachineData) {
                match ($postMachineDataKey) {
                    'zipCode', 'name', 'id' => $postMachinesWithFullAddress [$postMachineKey][$postMachineDataKey] = $postMachineData,
                    default => $fulAddress [] = $postMachineData
                };
            }

            $postMachinesWithFullAddress [$postMachineKey]['fullAddress'] = implode(' ',
                array_filter($fulAddress));
        }

        return $postMachinesWithFullAddress;
    }

    /**
     * @throws Exception
     */
    public function prepareSpreadsheet (array $postMachines): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle("Paštomatų sąrašas");

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

        $sheet->getCell('C1')->setValue('Paštomatų sąrašas');
        $sheet->getCell('D1')->setValue('Sugeneruota:');
        $sheet->getCell('E1')->setValue((new \DateTime('NOW'))->format('Y-m-d H:i:s'));

        foreach ($postMachines as $key => $postMachine) {
            $sheet->getCell('A' . $key + 4)->setValue($postMachine['zipCode']);
            $sheet->getCell('B' . $key + 4)->setValue($postMachine['name']);
            $sheet->getCell('C' . $key + 4)->setValue($postMachine['fullAddress']);
        }

        return $spreadsheet;
    }

    public function getPostMachines(): array
    {
        $filter = $_GET['filter'] ?? [];
        $allPostMachines = $this->omnivaRepository->selectSpecifiedDataOfPostMachines($filter);
        $postMachines = $this->createFullAddress($allPostMachines);

        return [$postMachines, $filter];
    }
}

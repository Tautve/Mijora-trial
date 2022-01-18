<?php

namespace App\Service;

use App\Repository\OmnivaRepository;
use DateTime;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\Request;

class OmnivaService
{
    public function __construct(private OmnivaRepository $omnivaRepository)
    {
    }

    public function createFullAddress(array $postMachines): array
    {
        $postMachinesWithFullAddress = [];
        foreach ($postMachines as $postMachineKey => $postMachine) {
            $fullAddress = [];
            foreach ($postMachine as $postMachineDataKey => $postMachineData) {
                match ($postMachineDataKey) {
                    'zipCode', 'name', 'id' =>
                    $postMachinesWithFullAddress [$postMachineKey][$postMachineDataKey] = $postMachineData,
                    default => $fullAddress [] = $postMachineData
                };
            }

            $postMachinesWithFullAddress [$postMachineKey]['fullAddress'] = implode(
                ' ',
                array_filter($fullAddress)
            );
        }

        return $postMachinesWithFullAddress;
    }

    /**
     * @throws Exception
     */
    public function prepareSpreadsheet(array $postMachines): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle("Paštomatų sąrašas");

        foreach (range('A', 'E') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        // set title
        $sheet->getCell('C1')->setValue('Paštomatų sąrašas');

        // set table head
        $sheet->getCell('A4')->setValue('Pašto kodas');
        $sheet->getCell('B4')->setValue('Pavadinimas');
        $sheet->getCell('C4')->setValue('Pilnas adresas');

        // set date
        $sheet->getCell('D1')->setValue('Sugeneruota:');
        $sheet->getCell('E1')->setValue((new DateTime('NOW'))->format('Y-m-d H:i:s'));

        foreach ($postMachines as $key => $postMachine) {
            $sheet->getCell('A' . $key + 5)->setValue($postMachine['zipCode']);
            $sheet->getCell('B' . $key + 5)->setValue($postMachine['name']);
            $sheet->getCell('C' . $key + 5)->setValue($postMachine['fullAddress']);
        }

        return $spreadsheet;
    }

    public function getPostMachines(Request $request): array
    {
        $filter = [];
        $queryParam = $request->query->all();

        if (array_key_exists('filter', $queryParam) && is_array($queryParam['filter'])) {
            $filter = $queryParam['filter'];
        }

        if ($filter) {
            foreach ($filter as &$item) {
                $item = trim($item);
            }
            unset($item);
        }

        $allPostMachines = $this->omnivaRepository->selectSpecifiedDataOfPostMachines($filter);
        $postMachines = $this->createFullAddress($allPostMachines);

        return [$postMachines, $filter];
    }
}

<?php

namespace App\Tests\src\Service;

use App\Tests\CustomWebTestCase;
use DateTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class OmnivaServiceTest extends CustomWebTestCase
{
    /**
     * @dataProvider postMachinesData
     */
    public function testCreateFullAddress(
        array $data
    ): void {
        $omnivaService = $this->getMockOmnivaService();

        $postMachinesWithFullAddress = $omnivaService->createFullAddress($data);

        // Assertions
        foreach ($postMachinesWithFullAddress as $key => $postMachineWithFullAddress) {
            self::assertSame(
                $data[$key]['zipCode'],
                $postMachineWithFullAddress['zipCode']
            );
            self::assertSame(
                $data[$key]['name'],
                $postMachineWithFullAddress['name']
            );

            foreach (range(0, 8) as $index) {
                self::assertStringContainsString(
                    $data[$key]['a' . $index . 'Name'],
                    $postMachineWithFullAddress['fullAddress']
                );
            }
        }
    }

    /**
     * @dataProvider postMachinesData
     */
    public function testPrepareSpreadsheet(
        array $data
    ): void {
        $omnivaService = $this->getMockOmnivaService();

        $postMachinesWithFullAddress = $omnivaService->createFullAddress($data);

        $spreadsheet = $omnivaService->prepareSpreadsheet($postMachinesWithFullAddress);

        $title = $spreadsheet->getWorksheetIterator()->current()->getTitle();

        // Assertions
        self::assertSame('Paštomatų sąrašas', $title);
        self::assertSame(
            'Sugeneruota:',
            $this->getCellValue($spreadsheet, 'D1')
        );
        self::assertLessThanOrEqual(
            (new DateTime($this->getCellValue(
                $spreadsheet,
                'E1'
            )))->getTimestamp(),
            (new DateTime('- 3 seconds'))->getTimestamp()
        );

        foreach ($postMachinesWithFullAddress as $key => $postMachineWithFullAddress) {
            self::assertSame(
                $postMachineWithFullAddress['zipCode'],
                $this->getCellValue($spreadsheet, 'A' . (5 + $key))
            );
            self::assertSame(
                $postMachineWithFullAddress['name'],
                $this->getCellValue($spreadsheet, 'B' . (5 + $key))
            );
            self::assertSame(
                $postMachineWithFullAddress['fullAddress'],
                $this->getCellValue($spreadsheet, 'C' . (5 + $key))
            );
        }
    }

    public function postMachinesData(): array
    {
        return [
            [
                [
                    [
                        'zipCode' => '12345',
                        'name' => 'Pastomatas1',
                        'a0Name' => 'LT',
                        'a1Name' => 'Vilniaus apskr.',
                        'a2Name' => 'Vilniaus m. sav.',
                        'a3Name' => 'Vilniaus m.',
                        'a4Name' => '',
                        'a5Name' => 'Vokiečių g.',
                        'a6Name' => '',
                        'a7Name' => '10',
                        'a8Name' => '12'
                    ],
                    [
                        'zipCode' => '12346',
                        'name' => 'Pastomatas2',
                        'a0Name' => 'LT',
                        'a1Name' => 'Alytaus apskr.',
                        'a2Name' => 'Alytaus m. sav.',
                        'a3Name' => 'Alytus m.',
                        'a4Name' => 'Šiaurinis',
                        'a5Name' => 'Vilniaus g.',
                        'a6Name' => 'centras',
                        'a7Name' => '10',
                        'a8Name' => '12'
                    ]
                ],
            ],
        ];
    }

    protected function getCellValue(
        Spreadsheet $spreadsheet,
        string $cell
    ): string {
        return $spreadsheet->getWorksheetIterator()->current()
            ->getCellCollection()->get($cell)->getValue();
    }
}

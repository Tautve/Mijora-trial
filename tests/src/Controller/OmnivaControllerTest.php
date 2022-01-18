<?php

namespace App\Tests\src\Controller;

use App\DataFixtures\OmnivaFixtures;
use App\Tests\CustomWebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Component\DomCrawler\Crawler;

class OmnivaControllerTest extends CustomWebTestCase
{
    protected $client;
    private $prefix = '/omniva/post-machines/';

    public function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
        self::getContainer()->get(DatabaseToolCollection::class)->get()
            ->loadFixtures([OmnivaFixtures::class]);
    }

    public function testShowAllPostMachines(): void
    {
        $crawler = $this->client->request('GET', $this->prefix . 'show');

        $rows = $crawler->filter('.omnivaDatatable tbody tr');

        // Assertions
        $this->assertCount(4, $rows);
    }

    /**
     * @dataProvider filterOptions
     */
    public function testShowAllFilteredPostMachines(
        string $zipCode,
        string $name,
        string $address,
        int $expectedResults
    ): void {
        $crawler = $this->client->request('GET', $this->prefix
            . 'show' . '?filter[zipCode]=' . $zipCode
                . '&filter[name]=' . $name . '&filter[address]=' . $address);

        $rows = $crawler->filter('.omnivaDatatable tbody tr');

        // Assertions
        $this->assertCount($expectedResults, $rows);
    }

    public function testShowPostMachineViaLink(): void
    {
        $crawler = $this->client->request(
            'GET',
            $this->prefix . '1/show'
        );

        // Assertions
        foreach ($this->createData($crawler) as $item) {
            $this->assertSame($item['expected'], $item['actual']);
        }
    }

    public function testShowPostMachineByClicking(): void
    {
        $crawler = $this->client->request('GET', $this->prefix . 'show');
        $rows = $crawler->filter('.omnivaDatatable tbody tr:first-child');

        $attr = $rows->attr('onclick');
        $this->assertNotEmpty($attr);

        $link = trim(substr($attr, strpos($attr, '=') + 1), "'");
        $crawler1 = $this->client->request('GET', $link);

        $form = $crawler1->filter('form');
        $postMachineName = $crawler1->filter('#post_machine_name')->html();

        // Assertions
        self::assertResponseNotHasHeader('location');
        self::assertCount(1, $form);
        self::assertSame('Pastomatas1', $postMachineName);
    }

    public function testExportPostMachinesListWithoutFilter(): void
    {
        $crawler = $this->client->request('GET', $this->prefix . 'show');
        $link = $crawler->selectLink('Atsiųsti sąrašą (.xls)')->link()->getUri();

        // Assertion
        self::assertNotEmpty($link);

        ob_start();
        $this->client->request('GET', $link);
        ob_end_clean();

        // Assertion
        self::assertEquals(200, $this->client->getInternalResponse()->getStatusCode());
    }

    /**
     * @dataProvider filterOptions
     */
    public function testQueryStringPassedToExportPostMachinesController(
        string $zipCode,
        string $name,
        string $address,
        int $expectedResults
    ): void {
        $queryString = '?filter[zipCode]=' . trim($zipCode)
            . '&filter[name]=' . trim($name) . '&filter[address]=' . trim($address);

        $crawler1 = $this->client->request(
            'GET',
            $this->prefix . 'show' . $queryString
        );

        $downloadButton = $crawler1->selectLink('Atsiųsti sąrašą (.xls)');
        if ($expectedResults > 0) {
            $link = $downloadButton->link()->getUri();

            // Assertion
            self::assertNotEmpty($link);

            ob_start();
            $crawler2 = $this->client->request('GET', $link);
            $retrievedQueryString = urldecode(substr(
                $crawler2->getUri(),
                strpos($crawler2->getUri(), '?')
            ));

            // Assertion
            self::assertSame($queryString, $retrievedQueryString);
            ob_end_clean();
        } else {
            // Assertion
            self::assertEmpty($downloadButton);
        }
    }

    private function getActualValue(Crawler $crawler, string $id): string
    {
        return $crawler->filter($id)->html();
    }

    private function createData(Crawler $crawler): array
    {
        $data = [];

        $data [] = [
            'expected' => '12345',
            'actual' => $this->getActualValue($crawler, '#post_machine_zipCode')
        ];
        $data [] = [
            'expected' => 'Pastomatas1',
            'actual' => $this->getActualValue($crawler, '#post_machine_name')
        ];
        $data [] = [
            'expected' => '1',
            'actual' => $this->getActualValue($crawler, '#post_machine_type')
        ];
        $data [] = [
            'expected' => 'LT',
            'actual' => $this->getActualValue($crawler, '#post_machine_a0Name')
        ];
        $data [] = [
            'expected' => 'Vilniaus apskr.',
            'actual' => $this->getActualValue($crawler, '#post_machine_a1Name')
        ];
        $data [] = [
            'expected' => 'Vilniaus m. sav.',
            'actual' => $this->getActualValue($crawler, '#post_machine_a2Name')
        ];
        $data [] = [
            'expected' => 'Vilniaus m.',
            'actual' => $this->getActualValue($crawler, '#post_machine_a3Name')
        ];
        $data [] = [
            'expected' => '',
            'actual' => $this->getActualValue($crawler, '#post_machine_a4Name')
        ];
        $data [] = [
            'expected' => 'Vilniaus g.',
            'actual' => $this->getActualValue($crawler, '#post_machine_a5Name')
        ];
        $data [] = [
            'expected' => '',
            'actual' => $this->getActualValue($crawler, '#post_machine_a6Name')
        ];
        $data [] = [
            'expected' => '10',
            'actual' => $this->getActualValue($crawler, '#post_machine_a7Name')
        ];
        $data [] = [
            'expected' => '12',
            'actual' => $this->getActualValue($crawler, '#post_machine_a8Name')
        ];
        $data [] = [
            'expected' => '12.345',
            'actual' => $this->getActualValue(
                $crawler,
                '#post_machine_xCoordinate'
            )
        ];
        $data [] = [
            'expected' => '14.543',
            'actual' => $this->getActualValue(
                $crawler,
                '#post_machine_yCoordinate'
            )
        ];
        $data [] = [
            'expected' => 'estonian comment',
            'actual' => $this->getActualValue(
                $crawler,
                '#post_machine_commentEst'
            )
        ];
        $data [] = [
            'expected' => 'english comment',
            'actual' => $this->getActualValue(
                $crawler,
                '#post_machine_commentEng'
            )
        ];
        $data [] = [
            'expected' => 'russian comment',
            'actual' => $this->getActualValue(
                $crawler,
                '#post_machine_commentRus'
            )
        ];
        $data [] = [
            'expected' => 'latvian comment',
            'actual' => $this->getActualValue(
                $crawler,
                '#post_machine_commentLav'
            )
        ];
        $data [] = [
            'expected' => 'lithuanian comment',
            'actual' => $this->getActualValue(
                $crawler,
                '#post_machine_commentLit'
            )
        ];

        return $data;
    }

    public function filterOptions(): array
    {
        return [
            ['123', '', '', 2],
            ['123 ', '', '', 2],
            [' 123 ', '', '', 2],
            ['62', '', '', 1],
            ['46', '', '', 1],
            ['46 ', '', '', 1],
            [' 46', '', '', 1],
            ['12345', '', '', 1],
            ['', 'Past', '', 4],
            ['', 'Past ', '', 4],
            ['', ' Past ', '', 4],
            ['', 'omat', '', 4],
            ['', 'matas1', '', 1],
            ['', 'Pastomatas2', '', 1],
            ['', '', 'Vilniaus', 2],
            ['', '', ' Vilniaus ', 2],
            ['', '', 'Viln', 2],
            ['', '', 'iaus', 2],
            ['', '', ' Vokiečių 54 ', 1],
            ['', '', 'Vokiečių 54', 1],
            ['', '', 'Vilniaus 12', 1],
            ['', '', 'LT Viln', 2],
            ['98', '', '', 0],
            ['', 'Pastomatas5', '', 0],
            ['123', 'Past', 'LT Viln', 1],
        ];
    }
}

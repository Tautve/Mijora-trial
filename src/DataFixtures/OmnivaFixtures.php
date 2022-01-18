<?php

namespace App\DataFixtures;

use App\Entity\Omniva;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OmnivaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->postMachines() as $data) {
            $omniva = new Omniva();
            $omniva->setZipCode($data[0] ?? null);
            $omniva->setName($data[1] ?? null);
            $omniva->setType($data[2] ?? null);
            $omniva->setA0Name($data[3] ?? null);
            $omniva->setA1Name($data[4] ?? null);
            $omniva->setA2Name($data[5] ?? null);
            $omniva->setA3Name($data[6] ?? null);
            $omniva->setA4Name($data[7] ?? null);
            $omniva->setA5Name($data[8] ?? null);
            $omniva->setA6Name($data[9] ?? null);
            $omniva->setA7Name($data[10] ?? null);
            $omniva->setA8Name($data[11] ?? null);
            $omniva->setXCoordinate($data[12] ?? null);
            $omniva->setYCoordinate($data[13] ?? null);
            $omniva->setServiceHours($data[14] ?? null);
            $omniva->setTempServiceHours($data[15] ?? null);
            $omniva->setTempServiceHoursUntil($data[16] ?? null);
            $omniva->setTempServiceHours2($data[17] ?? null);
            $omniva->setTempServiceHours2Until($data[18] ?? null);
            $omniva->setCommentEst($data[19] ?? null);
            $omniva->setCommentEng($data[20] ?? null);
            $omniva->setCommentRus($data[21] ?? null);
            $omniva->setCommentLav($data[22] ?? null);
            $omniva->setCommentLit($data[23] ?? null);
            $omniva->setModified((new DateTime($data[24])) ?? null);

            $manager->persist($omniva);
        }

        $manager->flush();
    }
    private function postMachines(): array
    {
        return [
            [
                '12345',
                'Pastomatas1',
                '1',
                'LT',
                'Vilniaus apskr.',
                'Vilniaus m. sav.',
                'Vilniaus m.',
                '',
                'Vilniaus g.',
                '',
                '10',
                '12',
                '12.345',
                '14.543',
                '',
                '',
                '',
                '',
                '',
                'estonian comment',
                'english comment',
                'russian comment',
                'latvian comment',
                'lithuanian comment',
                '2021-12-23 13:58:30'
            ],
            [
                '12346',
                'Pastomatas2',
                '0',
                'LV',
                'Ogres novads',
                'Madlienas pagasts',
                'Madliena',
                '',
                '',
                'Tirdzniecības centrs',
                '',
                '',
                '13.345',
                '15.543',
                '',
                '',
                '',
                '',
                '',
                'estonian comment',
                'english comment',
                'russian comment',
                'latvian comment',
                'lithuanian comment',
                '2021-11-23 13:58:30'
            ],
            [
                '75624',
                'Pastomatas3',
                '0',
                'EE',
                'Saare maakond',
                'Saaremaa vald',
                'Tornimäe küla',
                '',
                '',
                'Rahvamaja',
                '',
                '',
                '16.345',
                '17.543',
                '',
                '',
                '',
                '',
                '',
                'estonian comment',
                'english comment',
                'russian comment',
                'latvian comment',
                'lithuanian comment',
                '2021-10-23 13:58:30'
            ],
            [
                '77637',
                'Pastomatas4',
                '1',
                'LT',
                'Vilniaus apskr.',
                'Vilniaus m. sav.',
                'Vilniaus m.',
                '',
                'Vokiečių g.',
                '',
                '54',
                '32',
                '19.345',
                '12.543',
                '',
                '',
                '',
                '',
                '',
                'estonian comment',
                'english comment',
                'russian comment',
                'latvian comment',
                'lithuanian comment',
                '2020-12-23 13:58:30'
            ],
        ];
    }
}

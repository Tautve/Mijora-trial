<?php

namespace App\Service;

use App\Entity\Omniva;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use JsonException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SynchroniseDatabaseCommandService
{
    public function __construct(
        private HttpClientInterface $client,
        private string $omnivaUrl,
        private EntityManagerInterface $em
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws JsonException
     */
    public function fetchPostMachines()
    {
        $response = $this->client->request(
            'GET',
            $this->omnivaUrl
        );

        return json_decode($response->getContent(), true, 512,
            JSON_THROW_ON_ERROR);
    }

    public function savePostMachinesToDatabase(array $postMachines): void
    {
        foreach ($postMachines as $retrievedOmnivaMachine) {
            $omniva = new Omniva();
            $omniva->setZipCode($retrievedOmnivaMachine['ZIP']);
            $omniva->setName($retrievedOmnivaMachine['NAME']);
            $omniva->setType($retrievedOmnivaMachine['TYPE']);
            $omniva->setA0Name($retrievedOmnivaMachine['A0_NAME']);
            $omniva->setA1Name($retrievedOmnivaMachine['A1_NAME']);
            $omniva->setA2Name($retrievedOmnivaMachine['A2_NAME']);
            $omniva->setA3Name($retrievedOmnivaMachine['A3_NAME']);
            $omniva->setA4Name($retrievedOmnivaMachine['A4_NAME']);
            $omniva->setA5Name($retrievedOmnivaMachine['A5_NAME']);
            $omniva->setA6Name($retrievedOmnivaMachine['A6_NAME']);
            $omniva->setA7Name($retrievedOmnivaMachine['A7_NAME']);
            $omniva->setXCoordinate($retrievedOmnivaMachine['X_COORDINATE']);
            $omniva->setYCoordinate($retrievedOmnivaMachine['Y_COORDINATE']);
            $omniva->setServiceHours($retrievedOmnivaMachine['SERVICE_HOURS']);
            $omniva->setTempServiceHours($retrievedOmnivaMachine['TEMP_SERVICE_HOURS']);
            $omniva->setTempServiceHoursUntil($retrievedOmnivaMachine['TEMP_SERVICE_HOURS_UNTIL']);
            $omniva->setTempServiceHours2($retrievedOmnivaMachine['TEMP_SERVICE_HOURS_2']);
            $omniva->setTempServiceHours2Until($retrievedOmnivaMachine['TEMP_SERVICE_HOURS_2_UNTIL']);
            $omniva->setCommentEst($retrievedOmnivaMachine['comment_est']);
            $omniva->setCommentEng($retrievedOmnivaMachine['comment_eng']);
            $omniva->setCommentRus($retrievedOmnivaMachine['comment_rus']);
            $omniva->setCommentLav($retrievedOmnivaMachine['comment_lav']);
            $omniva->setCommentLit($retrievedOmnivaMachine['comment_lit']);
            $omniva->setModified(new DateTime($retrievedOmnivaMachine['MODIFIED']));

            $this->em->persist($omniva);
        }
        $this->em->flush();
    }
}

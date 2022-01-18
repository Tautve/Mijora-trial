<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class SynchroniseDatabaseCommandService
{
    public function __construct(
        private HttpClientInterface $client,
        private string $omnivaUrl,
    ) {
    }

    public function fetchPostMachines()
    {
        $response = $this->client->request(
            'GET',
            $this->omnivaUrl
        );

        return json_decode(
            $response->getContent(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}

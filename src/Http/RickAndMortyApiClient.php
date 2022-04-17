<?php

namespace App\Http;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class RickAndMortyApiClient
{
    private HttpClientInterface $httpClient;
    private const URL = 'https://rickandmortyapi.com/api';

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function fetchData()
    {
        $response = $this->httpClient->request('GET', self::URL, [

        ]);

        $test = json_decode($response->getContent())->characters;

        return $test;
    }
}
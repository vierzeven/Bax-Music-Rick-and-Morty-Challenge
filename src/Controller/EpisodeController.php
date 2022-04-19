<?php

namespace App\Controller;

use App\Http\RickAndMortyApiClient;

class EpisodeController
{
    /**
     * @var RickAndMortyApiClient
     */
    private $apiClient;

    /**
     * EpisodeController constructor method
     */
    public function __construct()
    {
        $this->apiClient = new RickAndMortyApiClient();
    }

    /**
     * Returns all episodes
     * @return mixed
     */
    public function index($page)
    {
        $episodes = $this->apiClient->callAPI('episode?page=' . $page);
        return isset($episodes['error']) ? [] : $episodes;
    }

    /**
     * Returns one specific episode
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $episode = $this->apiClient->callAPI('episode/' . $id);
        return isset($episode['error']) ? [] : $episode;
    }

}

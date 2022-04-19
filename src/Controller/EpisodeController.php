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
    public function show($id, $page)
    {
        $episode = $this->apiClient->callAPI('episode/' . $id);
        $characterIds = [];
        foreach ($episode['characters'] as $characterUrl) {
            $characterIds[] = explode('/', $characterUrl)[5];
        }
        // Calculate the number of pages (max 10 characters per page)
        $pages = ceil(sizeof($characterIds) / 10);
        // Prepare empty array
        $characters = [];
        // Calculate upper limit of for-loop
        $limit = $page * 10 - 1 < sizeof($characterIds) ? $limit = $page * 10 - 1 : $limit = sizeof($characterIds);
        // Fetch characters for this page
        for ($i = ($page - 1) * 10 ; $i < $limit ; $i++) {
            $characters[] = $this->apiClient->callAPI('character/' . $characterIds[$i]);
        }
        // Return data
        return isset($episode['error']) ? [] : [$episode, $characters, $pages];
    }

}

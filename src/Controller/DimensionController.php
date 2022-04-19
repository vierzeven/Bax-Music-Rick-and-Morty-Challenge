<?php

namespace App\Controller;

use App\Http\RickAndMortyApiClient;

class DimensionController
{
    /**
     * @var RickAndMortyApiClient
     */
    private $apiClient;

    /**
     * DimensionController constructor method
     */
    public function __construct()
    {
        $this->apiClient = new RickAndMortyApiClient();
    }

    /**
     * Returns all dimensions
     * @return mixed
     */
    public function index()
    {
        // Prepare empty array
        $dimensions = [];
        // Count the number of pages in the locations endpoint
        $pages = $this->apiClient->callAPI('location')['info']['pages'];
        // Loop through all pages...
        for ($i = 0; $i < $pages; $i++) {
            // From each page, fetch all locations...
            $locations = $this->apiClient->callAPI('location')['results'];
            // Loop through these locations...
            foreach ($locations as $location) {
                // ...and extract the dimension (if it has a name and is not yet present in the array)
                if ($location['dimension'] != 'unknown' and !in_array($location['dimension'], $dimensions)) {
                    $dimensions[] = $location['dimension'];
                }
            }
        }
        return $dimensions;
    }

    /**
     * Returns one specific dimension
     * @param $id
     * @return mixed
     */
    public function show($name, $page)
    {
        // Prepare empty array
        $residentIds = [];
        // Check the number of pages in the locations endpoint
        $pages = $this->apiClient->callAPI('location')['info']['pages'];
        // Loop through all pages...
        for ($i = 0; $i < $pages; $i++) {
            // From each page, fetch all locations...
            $locations = $this->apiClient->callAPI('location')['results'];
            // Loop through these locations...
            foreach ($locations as $location) {
                // ...and extract the residentIds!
                if ($location['dimension'] == $name) {
                    foreach ($location['residents'] as $residentUrl) {
                        $residentIds[] = explode('/', $residentUrl)[5];
                    }
                }
            }
        }
        // Remove duplicates and sort
        $residentIds = array_unique($residentIds);
        asort($residentIds);
        // Calculate the number of pages (max 10 characters per page)
        $pages = ceil(sizeof($residentIds) / 10);
        // Prepare empty array
        $characters = [];
        // Calculate upper limit of for-loop
        $limit = $page * 10 - 1 < sizeof($residentIds) ? $limit = $page * 10 - 1 : $limit = sizeof($residentIds);
        // Fetch characters for this page
        for ($i = ($page - 1) * 10 ; $i < $limit ; $i++) {
            $characters[] = $this->apiClient->callAPI('character/' . $residentIds[$i]);
        }
        // Return data
        return [$name, $characters, $pages];
    }

}

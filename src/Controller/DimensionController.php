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
                // ...and extract the dimension!
                if ($location['dimension'] != 'unknown' and !in_array($location['dimension'], $dimensions)) {
                    $dimensions[] = $location['dimension'];
                }
            }
        }
//        $dimensions = array_unique($dimensions);
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
        // Count the number of pages in the locations endpoint
        $pages = $this->apiClient->callAPI('location')['info']['pages'];
        // Loop through all pages...
        for ($i = 0; $i < $pages; $i++) {
            // From each page, fetch all locations...
            $locations = $this->apiClient->callAPI('location')['results'];
            // Loop through these locations...
            foreach ($locations as $location) {
                // ...and extract the residentIds!
                if ($location['dimension'] == $name) {
                    foreach ($location['residents'] as $resident) {
                        $residentIds[] = explode('/', $resident)[5];
                    }
                }
            }
        }
        $residentIds = array_unique($residentIds);
        asort($residentIds);
        $size = sizeof($residentIds);
        $pages = ceil($size / 10);
        $characters = [];
        if ($page * 10 - 1 < $size) {
            $limit = $page * 10 - 1;
        } else {
            $limit = $size;
        }
        for ($i = ($page - 1) * 10 ; $i < $limit ; $i++) {
            $characters[] = $this->apiClient->callAPI('character/' . $residentIds[$i]);
        }
        return [$name, $characters, $pages];
    }

}

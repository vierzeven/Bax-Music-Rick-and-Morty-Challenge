<?php

namespace App\Controller;

use App\Http\RickAndMortyApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LocationController extends AbstractController
{
    /**
     * @var RickAndMortyApiClient
     */
    private $apiClient;

    /**
     * CharacterController constructor method
     */
    public function __construct()
    {
        $this->apiClient = new RickAndMortyApiClient();
    }

    /**
     * Returns all locations
     * @return mixed
     */
    public function index($page)
    {
        $locations = $this->apiClient->callAPI('location?page=' . $page);
        if (isset($locations['error'])) {
            return [];
        } else {
            return $locations;
        }
    }

    /**
     * Returns one specific location
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->apiClient->callAPI('location/' . $id);
    }

}

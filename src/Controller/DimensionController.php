<?php

namespace App\Controller;

use App\Http\RickAndMortyApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function index($page)
    {
    }

    /**
     * Returns one specific dimension
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
    }

}

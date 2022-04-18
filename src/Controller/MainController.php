<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    private $characterController;
    private $locationController;

    /**
     * MainController constructor method
     * Instantiates all other controllers
     */
    public function __construct()
    {
        $this->characterController = new CharacterController();
        $this->locationController = new LocationController();
    }

    /**
     * Shows the homepage
     * @return Response
     */
    #[Route('/', name: 'homepage')]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    /**
     * Shows an index of characters
     * @return Response
     */
    #[Route('/character/page/{page}', name: 'character_index')]
    public function characterIndex($page): Response
    {
        $characters = $this->characterController->index($page);
        if (sizeof($characters) == 0) {
            return $this->redirectToRoute('homepage');
        }
        return $this->render('character/index.html.twig', [
            'characters' => $characters,
            'page' => $page
        ]);
    }

    /**
     * Shows one specific character
     * @param $id
     * @return Response
     */
    #[Route('/character/{id}', name: 'character_show')]
    public function characterShow($id): Response
    {
        return $this->render('character/show.html.twig', [
            'character' => $character = $this->characterController->show($id)
        ]);
    }

    /**
     * Shows an index of locations
     * @return Response
     */
    #[Route('/location/page/{page}', name: 'location_index')]
    public function locationIndex($page): Response
    {
        $locations = $this->locationController->index($page);
        if (sizeof($locations) == 0) {
            return $this->redirectToRoute('homepage');
        }
        return $this->render('location/index.html.twig', [
            'locations' => $locations,
            'page' => $page
        ]);
    }

    /**
     * Shows one specific location
     * @param $id
     * @return Response
     */
    #[Route('/location/{id}', name: 'location_show')]
    public function locationShow($id): Response
    {
        return $this->render('location/show.html.twig', [
            'location' => $location = $this->locationController->show($id)
        ]);
    }



    // Get characters for specific dimension
    #[Route('/character/dimension/{name}', name: 'characters_in_dimension')]
    public function characterIndexForDimension($name): Response
    {
        // Get all locations
        // TODO: Consider pagination!!
        $locations = $this->apiClient->callAPI('location');

        // Extract all dimensions
        $dimensions = [];
        foreach ($locations['results'] as $location) {
            $dimensions[] = $location['dimension'];
        }
        $dimensions = array_unique($dimensions);
        asort($dimensions);

        // Render view
        return $this->render('character/dimension.html.twig', [
            'output' => $dimensions
        ]);
    }
}
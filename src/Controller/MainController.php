<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    private $characterController;
    private $dimensionController;
    private $locationController;

    /**
     * MainController constructor method
     * Instantiates all other controllers
     */
    public function __construct()
    {
        $this->characterController = new CharacterController();
        $this->dimensionController = new DimensionController();
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
     * @param $page
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
        $character = $this->characterController->show($id);
        if (sizeof($character) == 0) {
            return $this->redirectToRoute('homepage');
        }
        return $this->render('character/show.html.twig', [
            'character' => $character = $this->characterController->show($id)
        ]);
    }

    /**
     * Shows an index of locations
     * @param $page
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

    /**
     * Shows an index of dimensions
     * @return Response
     */
    #[Route('/dimension', name: 'dimension_index')]
    public function dimensionIndex(): Response
    {
        $dimensions = $this->dimensionController->index();
        if (sizeof($dimensions) == 0) {
            return $this->redirectToRoute('homepage');
        }
        return $this->render('dimension/index.html.twig', [
            'dimensions' => $dimensions
        ]);
    }

    /**
     * Shows one specific dimension
     * @param $id
     * @return Response
     */
    #[Route('/dimension/{name}', name: 'dimension_show')]
    public function dimensionShow($name): Response
    {
        return $this->render('dimension/show.html.twig', [
            'dimension' => $dimension = $this->dimensionController->show($name)
        ]);
    }

}
<?php

namespace App\Controller;

use App\Plumbus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{

    // We use a private plumbus to call on the API
    private $plumbus;

    public function __construct()
    {
        $this->plumbus = new Plumbus();
    }

    // List all characters
    #[Route('/character', name: 'character_list')]
    public function list(): Response
    {
        $characters = $this->plumbus->callAPI('character');
        return $this->render('character/list.html.twig', [
            'characters' => $characters
        ]);
    }

    // Get one character
    #[Route('/character/{name}', name: 'character_show')]
    public function show($name): Response
    {
        $character = $this->plumbus->callAPI('character?name=' . $name);
        return $this->render('character/show.html.twig', [
            'character' => $character
        ]);
    }

}
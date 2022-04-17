<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    // List all characters
    #[Route('/', name: 'homepage')]
    public function home(): Response
    {
        return $this->render('home.html.twig', [

        ]);
    }
}
<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    #[Route('/lucky/number', name: 'number')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return $this->render('lucky/number.html.twig', [
            'number' => $number
        ]);
    }

    #[Route('/lucky/letter', name: 'letter')]
    public function letter(): Response
    {
        $letters = ['a', 'b', 'c', 'd'];
        $number = random_int(0, 3);

        return $this->render('lucky/letter.html.twig', [
            'letter' => $letters[$number]
        ]);
    }

    #[Route('/api/call1', name: 'characters')]
    public function call1(): Response
    {

        $characters = $this->callAPI('character');

        return $this->render('call1.html.twig', [
            'characters' => $characters
        ]);
    }

    private function callAPI($endpoint) {
        // create & initialize a curl session
        $curl = curl_init();

        // set our url with curl_setopt()
        curl_setopt($curl, CURLOPT_URL, "https://rickandmortyapi.com/api/{$endpoint}");

        // return the transfer as a string, also with setopt()
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // curl_exec() executes the started curl session
        // $output contains the output string
        $output = curl_exec($curl);

        // close curl resource to free up system resources
        // (deletes the variable made by curl_init)
        curl_close($curl);

        return json_decode($output, true);
    }

}
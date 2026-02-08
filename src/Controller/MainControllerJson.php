<?php

namespace App\Controller;

use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainControllerJson
{
    #[Route("/api/quote", name:"jsonquote", methods:['GET'])]
    public function jsonQuote(): Response
    {
        date_default_timezone_set('Europe/Stockholm');
        $randomquote = random_int(0, 6);
        $quotes = [
            'Nära skjuter ingen hare här på fortet - Gunde Svan',
            'Bazinga! - Sheldon Cooper',
            'Vart är vi på väg? - Ingvar Oldsberg, Kristian Luuk',
            'Du har vunnit hästen! - Leif "Loket" Olsson',
            'a² + b² = c² - Pythagoras',
            'My Precious - Gollum',
            'Where we´re going, we don´t need roads. - Dr. Emmet Brown',
        ];
        $date = new DateTime();

        $data = [
            'today' => $date->format('Y-m-d'),
            'todays_quote' => $quotes[$randomquote],
            'timestamp' => $date->format('Y-m-d H:i:s'),
        ];

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}

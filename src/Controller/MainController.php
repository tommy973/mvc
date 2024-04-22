<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {
        $number = random_int(0, 100);
        $bodycolornumber = random_int(0, 6);
        $backgroundnumber = random_int(0, 6);
        $fontcolornumber = random_int(0, 6);
        $colorwheel = ["red", "green", "blue", "yellow", "black", "grey", "white"];
        $colorwheelname = ["röd", "grön", "blå", "gul", "svart", "grå", "vit"];

        $data = [
            'luckynumber' => $number,
            'background' => $colorwheel[$backgroundnumber],
            'backgroundname' => $colorwheelname[$backgroundnumber],
            'fontcolor' => $colorwheel[$fontcolornumber],
            'fontcolorname' => $colorwheelname[$fontcolornumber],
            'bodycolor' => $colorwheel[$bodycolornumber],
            'bodycolorname' => $colorwheelname[$bodycolornumber]
        ];

        return $this->render('lucky.html.twig', $data);
    }

    #[Route("/api/", name:"api_index")]
    public function api_index(): Response
    {
        return $this->render('api.html.twig');
    }
}

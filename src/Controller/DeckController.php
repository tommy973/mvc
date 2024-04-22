<?php

namespace App\Controller;

use Tommy\Card\Card;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeckController extends AbstractController
{
    #[Route("/card", name: "card_landing")]
    public function home(
        SessionInterface $session
    ): Response
    {

        $testCard = new Card();

        $testCard->draw();

        $data = [
            'suit' => $testCard->getSuit(),
            'rank' => $testCard->getRank(),
        ];

        $session->set("cardsuit", $data['suit']);
        $session->set("cardrank", $data['rank']);

        return $this->render('card.html.twig', $data);
    }
}
<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DeckControllerJson
{
    #[Route("/api/deck", name:"jsondeck", methods: ['GET'])]
    public function jsonDeck(
        Request $request,
        SessionInterface $session
    ): Response
    {
        $deck = $session->get("currentdeck");

        if (empty($deck)) {
            $deck = new DeckOfCards();
        } else {
            $deck->sortDeck();
        }

        $data = [
            'deck' => $deck->getDeckAsStringArray(),
        ];

        $session->set("currentdeck", $deck);

        $response = new JsonResponse();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    #[Route("/api/deck/shuffle", name:"jsonshuffle", methods: ['POST'])]
    public function jsonShuffle(
        Request $request,
        SessionInterface $session
    ): Response
    {
        $deck = $session->get("currentdeck");

        $deck->shuffleDeck();

        $data = [
            'deck' => $deck->getDeckAsStringArray(),
        ];

        $session->set("currentdeck", $deck);

        $response = new JsonResponse();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    // #[Route("/api/deck/draw", name:"jsondraw", methods: ['POST'])]
    // public function jsonDraw(
    //     Request $request,
    //     SessionInterface $session
    // ): Response
    // {
    //     $deck = $session->get("currentdeck");

    //     if (empty($deck)) {
    //         $deck = new DeckOfCards();
    //     }

    //     $cardlimit = $deck->numberOfCardsInDeck();

    //     if ($cardlimit == 0) {
    //         throw new \Exception("Leken är slut, du kan inte dra fler kort.");
    //     }
        
    //     $singleCard = $deck->drawSingleCard();

    //     $drawnCard = [];
    //     $drawnCard[] = $singleCard->getCardAsString();

    //     $data = [
    //         'drawncard' => $drawnCard,
    //         'deckofcards' => $deck->getDeckAsStringArray(),
    //         'numberofcards' => $deck->numberOfCardsInDeck()
    //     ];

    //     $session->set("currentdeck", $deck);

    //     $response = new Response();
    //     $response->setContent(json_encode($data));
    //     $response->headers->set('Content-Type', 'application/json');

    //     return $response;
    // }

    #[Route("/api/deck/draw/{number<\d+>?1}", name:"jsondraw", methods: ['POST'])]
    public function jsonDraw(
        Request $request,
        SessionInterface $session,
        int $number
    ): Response
    {
        $deck = $session->get("currentdeck");

        // if (!isset($number)) {
        //     $number = $request->request->get('num_cards');
        // }

        $number = $request->request->get('num_cards');

        if (empty($deck)) {
            $deck = new DeckOfCards();
        }

        $cardlimit = $deck->numberOfCardsInDeck();

        if ($number > $cardlimit) {
            throw new \Exception("Du har dragit fler kort än som finns i leken");
        }

        if (isset($number)) {
            for ($i = 0; $i < $number; $i++) {
                $singleCard = $deck->drawSingleCard();
                $drawnCard[] = $singleCard->getCardAsString();
            }
        } else {
            $singleCard = $deck->drawSingleCard();
            $drawnCard = $singleCard->getCardAsString();
        }
        

        $data = [
            'drawncard' => $drawnCard,
            'deckofcards' => $deck->getDeckAsStringArray(),
            'numberofcards' => $deck->numberOfCardsInDeck()
        ];

        $session->set("currentdeck", $deck);

        $response = new JsonResponse();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    #[Route("/api/deck/draw/{number<\d+>?1}", name:"jsondeal", methods: ['POST'])]
    public function jsonDeal(
        Request $request,
        SessionInterface $session,
        int $number
    ): Response
    {
        $deck = $session->get("currentdeck");

        $number = $request->request->get('num_cards');

        if (empty($deck)) {
            $deck = new DeckOfCards();
        }

        $cardlimit = $deck->numberOfCardsInDeck();

        if ($number > $cardlimit) {
            throw new \Exception("Du har dragit fler kort än som finns i leken");
        }

        for ($i = 0; $i < $number; $i++) {
            $singleCard = $deck->drawSingleCard();
            $drawnCard[] = $singleCard->getCardAsString();
        }

        $data = [
            'drawncard' => $drawnCard,
            'deckofcards' => $deck->getDeckAsStringArray(),
            'numberofcards' => $deck->numberOfCardsInDeck()
        ];

        $session->set("currentdeck", $deck);

        $response = new JsonResponse();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}

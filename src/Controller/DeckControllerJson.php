<?php

namespace App\Controller;

use App\Card\CardHand;
use App\Card\DeckOfCards;
use Exception;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DeckControllerJson
{
    #[Route("/api/deck", name: "jsondeck", methods: ['GET'])]
    public function jsonDeck(
        SessionInterface $session
    ): Response {
        $deck = $session->get("currentdeck");

        if (empty($deck)) {
            $deck = new DeckOfCards();
        }

        $deck->sortDeck();

        $data = [
            'deck' => $deck->getDeckAsStringArray(),
        ];

        $session->set("currentdeck", $deck);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck/shuffle", name: "jsonshuffle", methods: ['GET'])]
    public function jsonShuffle(
        SessionInterface $session
    ): Response {
        $deck = $session->get("currentdeck");

        $deck->shuffleDeck();

        $data = [
            'deck' => $deck->getDeckAsStringArray(),
        ];

        $session->set("currentdeck", $deck);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    // #[Route("/api/deck/draw", name: "jsondrawsingle", mehtods:)]

    #[Route("/api/deck/draw/{number<\d+>?1}", name: "jsondraw", methods: ['POST', 'GET'])]
    public function jsonDraw(
        Request $request,
        SessionInterface $session,
        int $number
    ): Response {
        $deck = $session->get("currentdeck");

        // if (!isset($number)) {
        //     $number = $request->request->get('num_cards');
        // }

        $number = $request->request->get('num_cards');

        if (empty($deck)) {
            $deck = new DeckOfCards();
        }

        $cardlimit = $deck->numberOfCardsInDeck();
        $drawnCard = [];

        if ($number > $cardlimit) {
            throw new Exception("Du har dragit fler kort än som finns i leken");
        }

        // if (isset($number)) {
        for ($i = 0; $i < $number; $i++) {
            $singleCard = $deck->drawSingleCard();
            $drawnCard[] = $singleCard->getCardAsString();
        }
        // } elseif (!isset($number)) {
        //     $singleCard = $deck->drawSingleCard();
        //     $drawnCard = $singleCard->getCardAsString();
        // }


        $data = [
            'drawncard' => $drawnCard,
            'deckofcards' => $deck->getDeckAsStringArray(),
            'numberofcards' => $deck->numberOfCardsInDeck(),
        ];

        $session->set("currentdeck", $deck);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck/deal/{players:players<\d+>?1}/{number:number<\d+>?1}", name: "jsondeal", methods: ['POST'])]
    public function jsonDeal(
        Request $request,
        SessionInterface $session,
        int $number,
        int $players
    ): Response {
        $deck = $session->get("currentdeck");
        $cardHands = [];
        $cardhandsArray = [];

        (int) $number = $request->request->get('num_cards');
        (int) $players = $request->request->get('num_players');

        if (empty($deck)) {
            $deck = new DeckOfCards();
        }

        $cardlimit = $deck->numberOfCardsInDeck();

        if (((int) $number * (int) $players) > $cardlimit) {
            throw new Exception("Du har dragit fler kort än som finns i leken");
        }

        for ($i = 0; $i < $players; $i++) {
            $cardHands[] = new CardHand();
            for ($j = 0; $j < $number; $j++) {
                $cardHands[$i]->add($deck->drawSingleCard());
            }
            $cardhandsArray[] = $cardHands[$i]->getHandAsString();
            $session->set("cardhand$i", $cardHands[$i]);
        }

        $data = [
            'cardhands' => $cardhandsArray,
            'deckofcards' => $deck->getDeckAsStringArray(),
            'numberofcards' => $deck->numberOfCardsInDeck(),
        ];

        $session->set("currentdeck", $deck);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}

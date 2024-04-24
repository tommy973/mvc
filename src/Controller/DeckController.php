<?php

namespace App\Controller;

use Tommy\Card\Card;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Tommy\Card\DeckOfCards;

class DeckController extends AbstractController
{
    #[Route("/card", name: "card_landing")]
    public function card_landing(
        SessionInterface $session
    ): Response
    {
        // $testCard = new Card();

        // $testCard->draw();

        // $data = [
        //     'suit' => $testCard->getSuit(),
        //     'rank' => $testCard->getRank(),
        // ];

        // $testDeck = new DeckOfCards();

        // $shuffledDeck = $testDeck->shuffleDeck();

        // $sortedDeck = $testDeck->sortDeck();

        // $testDeck->shuffleDeck();

        // $testDeck->drawSingleCard();

        // $data = [
        //     'deckofcards' => $testDeck->getCardsAsString(),
        //     'shuffledDeck' => $testDeck->shuffleDeck(),
        //     'shuffledcards' => $testDeck->getCardsAsString(),
        //     'sortedDeck' => $testDeck->sortDeck(),
        //     'sortedcards' => $testDeck->getCardsAsString(),
        // ];

        // $session->set("cardsuit", $data['suit']);
        // $session->set("cardrank", $data['rank']);

        return $this->render('card.html.twig');
    }

    #[Route("/card/deck", name: "all_cards_in_deck")]
    public function allCardsInDeck(
        SessionInterface $session
    ): Response
    {
        // $testCard = new Card();

        // $testCard->draw();

        // $data = [
        //     'suit' => $testCard->getSuit(),
        //     'rank' => $testCard->getRank(),
        // ];
        $deck = $session->get("currentdeck");
        if (empty($currentDeck)) {
            $deck = new DeckOfCards();
        } else {
            $deck->sortDeck();
        }

        // $testDeck->shuffleDeck();

        // $testDeck->drawSingleCard();

        $data = [
            'deckofcards' => $deck->getCardsAsString(),
        ];

        $session->set("currentdeck", $deck);

        // $session->set("cardsuit", $data['suit']);
        // $session->set("cardrank", $data['rank']);

        return $this->render('cards/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "shuffled_deck_of_cards")]
    public function shuffledDeckOfCards(
        SessionInterface $session
    ): Response
    {
        // $testCard = new Card();

        // $testCard->draw();

        // $data = [
        //     'suit' => $testCard->getSuit(),
        //     'rank' => $testCard->getRank(),
        // ];

        $deck = new DeckOfCards();

        $deck->shuffleDeck();

        // $testDeck->drawSingleCard();

        $data = [
            'deckofcards' => $deck->getCardsAsString(),
        ];

        $session->set("currentdeck", $deck);
        // $session->set("cardrank", $data['rank']);

        return $this->render('cards/deck.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "draw_card")]
    public function DrawCardFromDeck(
        SessionInterface $session
    ): Response
    {

        $deck = $session->get("currentdeck");

        $cardlimit = $deck->numberOfCardsInDeck();

        if ($cardlimit == 0) {
            throw new \Exception("Leken är slut, du kan inte dra fler kort.");
        }
        
        $drawnCard = [];
        $drawnCard[] = $deck->drawSingleCard();


        // $testDeck->drawSingleCard();

        $data = [
            'deckofcards' => $deck->getCardsAsString(),
            'drawncard' => $drawnCard,
            'numberofcards' => $deck->numberOfCardsInDeck()
        ];

        $session->set("currentdeck", $deck);

        return $this->render('cards/drawcard.html.twig', $data);
    }

    #[Route("/card/deck/draw/{number<\d+>}", name: "draw_cards")]
    public function DrawCardsFromDeck(
        SessionInterface $session,
        int $number
    ): Response
    {
        $deck = $session->get("currentdeck");

        $cardlimit = $deck->numberOfCardsInDeck();

        if ($number > $cardlimit) {
            throw new \Exception("Du har dragit fler kort än som finns i leken");
        }

        $drawncards = [];
        
        for ($i = 0; $i < $number; $i++) {
            $drawncards[] = $deck->drawSingleCard();
        }

        $data = [
            'deckofcards' => $deck->getCardsAsString(),
            'drawncard' => $drawncards,
            'numberofcards' => $deck->numberOfCardsInDeck()
        ];

        $session->set("currentdeck", $deck);

        return $this->render('cards/drawcard.html.twig', $data);
    }
}
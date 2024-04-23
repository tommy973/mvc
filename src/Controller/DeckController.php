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
}
<?php

namespace App\Controller;

use Tommy\Card\Card;
use Tommy\Card\CardHand;
use Tommy\Card\DeckOfCards;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeckController extends AbstractController
{
    // Main landing route
    #[Route("/card", name: "card_landing")]
    public function card_landing(
        SessionInterface $session
    ): Response
    {
        return $this->render('card.html.twig');
    }

    // Sorts deck
    #[Route("/card/deck", name: "all_cards_in_deck")]
    public function allCardsInDeck(
        SessionInterface $session
    ): Response
    {
        // Checks if there is a deck in session. If not, a deck is created.
        $deck = $session->get("currentdeck");

        if (empty($deck)) {
            $deck = new DeckOfCards();
        } else {
            $deck->sortDeck();
        }

        $data = [
            'deckofcards' => $deck->getDeckAsStringArray(),
            'deck' => $deck,
        ];

        $session->set("currentdeck", $deck);

        return $this->render('cards/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "shuffled_deck_of_cards")]
    public function shuffledDeckOfCards(
        SessionInterface $session
    ): Response
    {
        $deck = new DeckOfCards();

        $deck->shuffleDeck();

        $data = [
            'deckofcards' => $deck->getDeckAsStringArray(),
            'deck' => $deck,
        ];

        $session->set("currentdeck", $deck);

        return $this->render('cards/shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "draw_card")]
    public function DrawCardFromDeck(
        SessionInterface $session
    ): Response
    {

        $deck = $session->get("currentdeck");

        if (empty($deck)) {
            $deck = new DeckOfCards();
        }

        $cardlimit = $deck->numberOfCardsInDeck();

        if ($cardlimit == 0) {
            throw new \Exception("Leken är slut, du kan inte dra fler kort.");
        }
        
        $singleCard = $deck->drawSingleCard();

        $drawnCard = [];
        $drawnCard[] = $singleCard->getCardAsString();

        $data = [
            'deckofcards' => $deck->getDeckAsStringArray(),
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
            'deckofcards' => $deck->getDeckAsStringArray(),
            'drawncard' => $drawnCard,
            'numberofcards' => $deck->numberOfCardsInDeck()
        ];

        $session->set("currentdeck", $deck);

        return $this->render('cards/drawcard.html.twig', $data);
    }

    #[Route("/card/deck/dealinit", name: "deal_cards_init", methods: ['GET'])]
    public function DealCardsInit(
        SessionInterface $session
    ): Response
    {
        return $this->render('cards/dealcard.html.twig');
    }

    #[Route("/card/deck/dealinit", name: "deal_cards_init_post", methods: ['POST'])]
    public function DealCardsInitPost(
        Request $request,
        SessionInterface $session
    ): Response
    {
        $numPlayers = $request->request->get('num_players');
        $numCards = $request->request->get('num_cards');

        return $this->redirectToRoute('deal_cards', ['players' => $numPlayers, 'cards' => $numCards]);
    }


    #[Route("/card/deck/deal/{players<\d+>}/{cards<\d+>}", name: "deal_cards")]
    public function DealCardsFromDeck(
        SessionInterface $session,
        int $players,
        int $cards
    ): Response
    {
        $deck = $session->get("currentdeck");

        if (empty($deck)) {
            $deck = new DeckOfCards();
        }

        $cardlimit = $deck->numberOfCardsInDeck();

        if ($players < 1 || $players > 52) {
            throw new \Exception("Du måste välja ett giltigt antal spelare (1 - 52)");
        }

        if (($cards * $players) > $cardlimit){
            throw new \Exception("Antalet kort räcker inte till alla spelare");
        }

        for ($i = 0; $i < $players; $i++) {
            $cardHands[] = new CardHand();
            for ($j = 0; $j < $cards; $j++) {
                $cardHands[$i]->add($deck->drawSingleCard());
            }
            // $temp['cardhand' . $i] = $cardHands[$i];
            $cardhandsArray[] = $cardHands[$i]->getHandAsString();
            $session->set("cardhand$i", $cardHands[$i]);
        }
        $session->set("currentdeck", $deck);

        $deck->sortDeck();

        $data = [
            'numberofplayers' => $players,
            'numberofcards' => $cards,
            'cardhand' => $cardhandsArray,
            'deckofcards' => $deck->getDeckAsStringArray(),
        ];

        

        return $this->render('cards/dealtcard.html.twig', $data);
    }
}
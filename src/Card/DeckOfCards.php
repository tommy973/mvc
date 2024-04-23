<?php

namespace Tommy\Card;

use Tommy\Card\Card;

class DeckOfCards
{
    private $deck = [];

    /**
     * Creates a deck of 52 cards, sorted by suits and ranks
     */
    public function __construct()
    {
        $suits = ['hearts', 'spades', 'diamonds', 'clubs'];
        $ranks = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13'];

        for ($i = 0; $i < count($suits); $i++) {
            for ($j = 0; $j < count($ranks); $j++) {
                $this->deck[] = new Card($suits[$i], $ranks[$j]);
            }
        }
    }

    public function getCardsAsString(): array
    {
        $cards = [];
        foreach ($this->deck as $singleCard) {
            $cards[] = $singleCard->getRank() . " of " . $singleCard->getSuit();
        }
        return $cards;
    }

    /**
     * Shuffles the deck
     */
    public function shuffleDeck()
    {
        shuffle($this->deck);
        // return $this->deck;
    }

    /**
     * Sorts the deck according to the arrays below
     */
    public function sortDeck()
    {
        $this->deck = [];
        
        $suits = ['hearts', 'spades', 'diamonds', 'clubs'];
        $ranks = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13'];

        for ($i = 0; $i < count($suits); $i++) {
            for ($j = 0; $j < count($ranks); $j++) {
                $this->deck[] = new Card($suits[$i], $ranks[$j]);
            }
        }

        // return $this->deck;
    }

    /**
     * Counts the number of cards in a deck
     * @return integer The amount of cards
     */
    public function numberOfCardsInDeck(): int
    {
        return count($this->deck);
    }

    /**
     * Draw and removes a single card from the deck
     * @return string The drawn card
     */
    public function drawSingleCard()
    {
        $randomCard = random_int(0, $this->numberOfCardsInDeck() - 1);

        $currentCard = $this->deck[$randomCard];

        array_splice($this->deck, $randomCard, 1);
        return $currentCard->getRank() . " of " . $currentCard->getSuit();

    }
}

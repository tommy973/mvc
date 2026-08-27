<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;

class DeckOfCards
{
    private $deck = [];

    /**
     * Creates a deck of 52 cards, sorted by suits and ranks
     */
    public function __construct()
    {
        $suits = ['0', '1', '2', '3'];
        $ranks = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
        // $ranks = ['0', '9'];

        for ($i = 0; $i < count($suits); $i++) {
            for ($j = 0; $j < count($ranks); $j++) {
                $this->deck[] = new CardGraphic($suits[$i], $ranks[$j]);
            }
        }
    }

    /**
     * Function to get a printable array with all the remaining cards in the deck
     * @return array with all cards in the deck as "Rank of Suit"
     */
    public function getDeckAsStringArray(): array
    {
        $cards = [];
        foreach ($this->deck as $singleCard) {
            // $cards[] = $singleCard->getRankAsString() . " of " . $singleCard->getSuitAsString();
            $cards[] = $singleCard->getCardAsString();
        }
        return $cards;
    }

    /**
     * Shuffles the deck
     */
    public function shuffleDeck()
    {
        shuffle($this->deck);
    }

    /**
     * Sorts the deck
     */
    public function sortDeck()
    {
        sort($this->deck);
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
     * @return object The drawn card
     */
    public function drawSingleCard()
    {
        $randomCard = random_int(0, $this->numberOfCardsInDeck() - 1);
        // $randomCard = 2;
        $currentCard = $this->deck[$randomCard];

        array_splice($this->deck, $randomCard, 1);
        return $currentCard;
    }

    /**
     * Removes the cards that are currently drawn by the players
     */
    public function removeCards(CardHand $handToRemove)
    {
        $removeCards = [];
        $counter = 0;
        foreach ($this->getDeck() as $deckCard) {
            echo $counter;
            foreach ($handToRemove->getHand() as $card) {
                if (($card->getSuit() == $deckCard->getSuit()) and ($card->getRank() == $deckCard->getRank())) {
                    $removeCards[] = $counter;
                }
            }
            $counter += 1;
        }

        for ($i = count($removeCards) - 1; $i >= 0; $i--) {
            array_splice($this->deck, $removeCards[$i], 1);
        }
    }

    /**
     * Function to get the current Deck as an array
     * @return array The current deck
     */
    public function getDeck(): array
    {
        return $this->deck;
    }
}

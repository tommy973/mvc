<?php

namespace App\Card;

class Card
{
    protected string $suit;
    protected string $rank;

    public function __construct(string $suit, string $rank)
    {
        $this->suit = $suit;
        $this->rank = $rank;
    }

    public function getSuit(): ?string
    {
        return $this->suit;
    }

    public function getRank(): ?string
    {
        return $this->rank;
    }

    public function getSuitAsString(): ?string
    {
        $suits = ['Hearts', 'Spades', 'Diamonds', 'Clubs'];

        return $suits[$this->suit];
    }

    public function getRankAsString(): ?string
    {
        $ranks = ['Ace', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Jack', 'Queen', 'King'];

        return $ranks[$this->rank];
    }

    public function getCardAsString(): ?string
    {
        $currentcard = $this->getRankAsString() . " of " . $this->getSuitAsString();
        return $currentcard;
    }
}

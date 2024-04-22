<?php

namespace Tommy\Card;

class Card {

    protected $suit;
    protected $rank;

    public function __construct()
    {
        $this->suit = null;
        $this->rank = null;
    }

    public function draw()
    {
        $suits = ['hearts', 'spades', 'diamonds', 'clubs'];
        $ranks = ['ace', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'jack', 'queen', 'king'];

        $randomSuit = random_int(0, 3);
        $randomRank = random_int(0, 12);
        $this->suit = $suits[$randomSuit];
        $this->rank = $ranks[$randomRank];
    }

    public function getSuit(): ?string
    {
        return $this->suit;
    }

    public function getRank(): ?string
    {
        return $this->rank;
    }

}
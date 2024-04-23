<?php

namespace Tommy\Card;

class Card {

    protected $suit;
    protected $rank;

    public function __construct($suit = null, $rank = null)
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
}
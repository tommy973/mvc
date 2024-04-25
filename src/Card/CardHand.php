<?php

namespace Tommy\Card;

use Tommy\Card\Card;

class CardHand
{
    private $hand = [];

    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }

    public function getHandAsString(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getCardAsString();
        }
        return $values;
    }
}
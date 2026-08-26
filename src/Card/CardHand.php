<?php

namespace App\Card;

use App\Card\Card;

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

    public function getHandSum(): int
    {
        $sum = 0;
        foreach ($this->hand as $card) {
            $sum += (int) $card->getRank() + 1;
        }

        return $sum;
    }

    public function numberOfCardsInHand(): int
    {
        return count($this->hand);
    }

    public function getHand(): array
    {
        return $this->hand;
    }
}

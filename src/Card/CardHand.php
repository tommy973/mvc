<?php

namespace App\Card;

use App\Card\Card;

class CardHand
{
    /**
     * @var array<mixed>
     */
    private array $hand = [];

    public function add(object $card): void
    {
        $this->hand[] = $card;
    }

    /**
     * @return list<String|null>
     */
    public function getHandAsString()
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

    /**
     * @return array<Card>
     */
    public function getHand(): array
    {
        return $this->hand;
    }
}

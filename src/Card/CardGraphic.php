<?php

namespace App\Card;

class CardGraphic extends Card
{
    /**
     * @var array<string>
     */
    private array $suitrep = ['♥', '♠', '♦', '♣',];

    /**
     * @var array<string>
     */
    private array $rankrep = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];

    protected string $suit;
    protected string $rank;

    public function __construct(string $suit, string $rank)
    {
        $this->suit = $suit;
        $this->rank = $rank;
    }

    public function getSuitAsString(): string
    {
        return $this->suitrep[$this->suit];
    }

    public function getRankAsString(): string
    {
        return $this->rankrep[$this->rank];
    }

    public function getCardAsString(): ?string
    {
        $currentcard = $this->rankrep[intval($this->rank)] . $this->suitrep[intval($this->suit)];
        return $currentcard;
    }
}

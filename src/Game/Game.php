<?php

namespace App\Game;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Game
{
    /**
     * @var DeckOfCards
     */
    public DeckOfCards $deck;

    /**
     * @var CardHand
     */
    public CardHand $playerhand;

    /**
     * @var CardHand
     */
    public CardHand $bankhand;

    public int $playerpoints;
    public int $bankpoints;
    public string $gamephase;

    public function __construct()
    {
        $this->deck = new DeckOfCards();
        $this->playerhand = new CardHand();
        $this->bankhand = new CardHand();
        $this->playerpoints = 0;
        $this->bankpoints = 0;
        $this->gamephase = "playersturn";
    }

    /**
     * @return array<String>
     */
    public function startUpGame(SessionInterface $session): array
    {
        $gameStarted = $session->get("gamestarted");

        if (empty($gameStarted)) {
            $gameStarted = false;
        }
        $this->deck = new DeckOfCards();

        $data = [
            'gamestarted' => $gameStarted,
        ];

        return $data;
    }

    public function initGame(): void
    {
        if ($this->deck->numberOfCardsInDeck() == 0) {
            $this->deck = new DeckOfCards();
        }

        if (empty($this->playerpoints)) {
            $this->playerpoints = 0;
        }

        if (empty($this->bankpoints)) {
            $this->bankpoints = 0;
        }

        $this->playerhand = new CardHand();
        $this->bankhand = new CardHand();
        $this->gamephase = "playersturn";
    }

    /**
     * @return array<String, mixed>
     */
    public function playGame(SessionInterface $session): array
    {
        $outcome = "";
        $loss = false;
        $winner = "";

        $playerHandString = $this->playerhand->getHandAsString();
        $playerHandSum = $this->playerhand->getHandSum();
        if ($playerHandSum > 21) {
            $loss = true;
            $outcome = "Du fick över 21. Banken vann omgången.";
            $this->bankpoints += 1;
        }

        $bankHandString = $this->bankhand->getHandAsString();
        $bankHandSum = $this->bankhand->getHandSum();
        if ($bankHandSum > 21) {
            $loss = true;
            $outcome = "Banken fick över 21. Du vann omgången";
            $this->playerpoints += 1;
        }

        // Jämför om det är decide
        if ($this->gamephase == "decide") {
            $winner = "bank";
            $outcome = "Aj då. Banken vann den här omgången.";
            $this->bankpoints += 1;
            if ($playerHandSum > $bankHandSum) {
                $winner = "player";
                $outcome = "Grattis, Du vann den här omgången.";
                $this->playerpoints += 1;
                $this->bankpoints -= 1;
            }
        }

        $data = [
            'playerdrawncards' => $playerHandString,
            'playersum' => $playerHandSum,
            'bankdrawncards' => $bankHandString,
            'banksum' => $bankHandSum,
            'gamephase' => $this->gamephase,
            'outcome' => $outcome,
            'loss' => $loss,
            'winner' => $winner,
            'playerpoints' => $this->playerpoints,
            'bankpoints' => $this->bankpoints,
            'gamedeck' => $this->deck,
            'playerhand' => $this->playerhand,
            'bankhand' => $this->bankhand,
            'gamestarted' => $session->get("gamestarted"),
        ];

        return $data;
    }

    public function drawCard(): void
    {
        if ($this->deck->numberOfCardsInDeck() <= 0) {
            $this->deck = new DeckOfCards();
            $this->deck->removeCards($this->playerhand);
            $this->deck->removeCards($this->bankhand);
        }

        $drawnCard = $this->deck->drawSingleCard();

        // Lägg kortet i spelarens hand om det är spelarens tur
        if ($this->gamephase == "playersturn") {
            $this->playerhand->add($drawnCard);
        }

        // Lägg kortet i bankens hand om det är bankens tur
        if ($this->gamephase == "banksturn") {
            $this->bankhand->add($drawnCard);
        }
    }

    public function pass(): void
    {
        // Om jämförelsen är gjord så startas en ny runda
        if ($this->gamephase == "decide") {
            $this->gamephase = "playersturn";
            $this->playerhand = new CardHand();
            $this->bankhand = new CardHand();
        }

        // Om banken är nöjd så ändras det till att jämföra summor
        elseif ($this->gamephase == "banksturn") {
            $this->gamephase = "decide";
        }

        // Om spelaren är nöjd så ändras det till bankens tur
        elseif ($this->gamephase == "playersturn") {
            $this->gamephase = "banksturn";
        }
    }

    /**
     * @return array<String, mixed>
     */
    public function getStatus(): array
    {
        $data = [
            'playerpoints' => $this->playerpoints,
            'bankpoints' => $this->bankpoints,
        ];

        return $data;
    }
}

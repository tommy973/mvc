<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    // Main landing route
    #[Route("/game", name: "game_landing")]
    public function gameLanding(
        SessionInterface $session
    ): Response {
        return $this->render('game.html.twig');
    }

    // Documentation
    #[Route("/game/doc", name: "game_doc")]
    public function gameDoc(
        SessionInterface $session
    ): Response {
        return $this->render('game/doc.html.twig');
    }

    // Game Start Route
    #[Route("/game/gamestart", name: "game_start")]
    public function gameStart(
        SessionInterface $session
    ): Response {
        $game_started = $session->get("game_started");
        $session->set("playerpoints", 0);
        $session->set("bankpoints", 0);

        if (empty($game_started)) {
            $game_started = false;
        }

        $data = [
            'gamestarted' => $game_started,
        ];

        return $this->render('game/gamestart.html.twig', $data);
    }

    // Game Init Route
    #[Route("game/gameinit", name: "game_init")]
    public function gameInit(
        SessionInterface $session
    ): Response {
        // $loss = $session->get("loss");
        $gamedeck = $session->get("gamedeck");
        $playerPoints = $session->get("playerpoints");
        $bankPoints = $session->get("bankpoints");

        if (empty($gamedeck)) {
            $gamedeck = new DeckOfCards();
        }

        if (empty($playerPoints)) {
            $playerPoints = 0;
        }

        if (empty($bankPoints)) {
            $bankPoints = 0;
        }

        $playerHand = new CardHand();
        $bankHand = new CardHand();

        $session->set("gamedeck", $gamedeck);
        $session->set("playerhand", $playerHand);
        $session->set("bankhand", $bankHand);
        $session->set("playerpoints", $playerPoints);
        $session->set("bankpoints", $bankPoints);
        $session->set("gamephase", "playersturn");

        return $this->redirectToRoute('game_play');
    }

    // Play Game Route
    #[Route("game/gameplay", name: "game_play")]
    public function gamePlay(
        SessionInterface $session
    ): Response {
        $gamephase = $session->get("gamephase");
        $gamedeck = $session->get("gamedeck");
        $playerHand = $session->get("playerhand");
        $bankHand = $session->get("bankhand");
        $playerPoints = $session->get("playerpoints");
        $bankPoints = $session->get("bankpoints");

        $outcome = "";
        $loss = false;
        $winner = "";

        $playerHand = $session->get("playerhand");
        $playerHandString = $playerHand->getHandAsString();
        $playerHandSum = $playerHand->getHandSum();
        if ($playerHandSum > 21) {
            $loss = true;
            $outcome = "Du fick över 21. Banken vann omgången.";
            $bankPoints += 1;
        }

        $bankHandString = $bankHand->getHandAsString();
        $bankHandSum = $bankHand->getHandSum();
        if ($bankHandSum > 21) {
            $loss = true;
            $outcome = "Banken fick över 21. Du vann omgången.";
            $playerPoints += 1;
        }

        // Jämför om det är decide
        if ($gamephase == "decide") {
            if ($playerHandSum > $bankHandSum) {
                $winner = "player";
                $outcome = "Grattis, Du vann den här omgången.";
                $playerPoints += 1;
            } else {
                $winner = "bank";
                $outcome = "Aj då, Banken vann den här omgången.";
                $bankPoints += 1;
            }
        }

        $session->set("playerpoints", $playerPoints);
        $session->set("bankpoints", $bankPoints);

        $data = [
            'playerdrawncards' => $playerHandString,
            'playersum' => $playerHandSum,
            'bankdrawncards' => $bankHandString,
            'banksum' => $bankHandSum,
            'gamephase' => $gamephase,
            'outcome' => $outcome,
            'loss' => $loss,
            'winner' => $winner,
            'playerpoints' => $playerPoints,
            'bankpoints' => $bankPoints,
            'gamedeck' => $session->get("gamedeck"),
            'playerhand' => $session->get("playerhand"),
            'bankhand' => $session->get("bankhand"),
            'gamestarted' => $session->get("gamestarted"),
        ];

        return $this->render('game/gameplay.html.twig', $data);
    }

    // Game Draw a card Route
    #[Route("game/gamedrawcard", name: "game_drawcard")]
    public function gameDrawCard(
        SessionInterface $session
    ): Response {
        $gamephase = $session->get("gamephase");
        // Draw a card
        $gameDeck = $session->get("gamedeck");
        $playerHand = $session->get("playerhand");
        $bankHand = $session->get("bankhand");

        if ($gameDeck->numberOfCardsInDeck() <= 0) {
            $gameDeck = new DeckOfCards();
            $gameDeck->removeCards($playerHand);
            $gameDeck->removeCards($bankHand);
        }

        $drawnCard = $gameDeck->drawSingleCard();

        // Lägg kort i spelarens hand om det är spelarens tur
        if ($gamephase == "playersturn") {
            $playerHand = $session->get("playerhand");
            $playerHand->add($drawnCard);
            $session->set("playerhand", $playerHand);
        }

        // Lägg kort i bankens hand om det är bankens tur
        if ($gamephase == "banksturn") {
            $bankHand = $session->get("bankhand");
            $bankHand->add($drawnCard);
            $session->set("bankhand", $bankHand);
        }



        // $playerHand = $session->get("playerhand");
        // $bankHand = $session->get("bankhand");


        // $playerHand->add($drawnCard);

        $session->set("gamedeck", $gameDeck);
        // $session->set("playerhand", $playerHand);
        // $session->set("bankhand", $bankHand);
        // $session->set("gamestarted", true);

        return $this->redirectToRoute('game_play');
    }

    // Game Pass Route
    #[Route("game/gamepass", name: "game_pass")]
    public function gamePass(
        SessionInterface $session
    ): Response {
        $gamephase = $session->get("gamephase");
        $loss = $session->get("loss");

        // Om jämförelsen är gjord så startas en ny runda
        if ($gamephase == "decide") {
            $session->set("gamephase", "playersturn");
            $newPlayerHand = new CardHand();
            $newBankHand = new CardHand();
            $session->set("playerhand", $newPlayerHand);
            $session->set("bankhand", $newBankHand);
        }

        // Om banken är nöjd så ändras det till att jämföra summor
        elseif ($gamephase == "banksturn") {
            if ($loss == true) {
                $session->set("gamephase", "playersturn");
                $newPlayerHand = new CardHand();
                $newBankHand = new CardHand();
                $session->set("playerhand", $newPlayerHand);
                $session->set("bankhand", $newBankHand);
            } else {
                $session->set("gamephase", "decide");
            }
        }

        // Om spelaren är nöjd så ändras det till bankens tur
        elseif ($gamephase == "playersturn") {
            if ($loss == true) {
                $session->set("gamephase", "playersturn");
                $newPlayerHand = new CardHand();
                $newBankHand = new CardHand();
                $session->set("playerhand", $newPlayerHand);
                $session->set("bankhand", $newBankHand);
            } else {
                $session->set("gamephase", "banksturn");
            }
        }

        return $this->redirectToRoute('game_play');
    }
}

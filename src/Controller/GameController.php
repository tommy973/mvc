<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Game\Game;
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
    ): Response {
        return $this->render('game.html.twig');
    }

    // Documentation
    #[Route("/game/doc", name: "game_doc")]
    public function gameDoc(
    ): Response {
        return $this->render('game/doc.html.twig');
    }

    // Game Start Route
    #[Route("/game/gamestart", name: "game_start")]
    public function gameStart(
        SessionInterface $session
    ): Response {
        $game = new Game();

        $data = $game->startUpGame($session);

        $session->set("currentgame", $game);

        return $this->render('game/gamestart.html.twig', $data);
    }

    // Game Init Route
    #[Route("game/gameinit", name: "game_init")]
    public function gameInit(
        SessionInterface $session
    ): Response {
        $game = $session->get("currentgame");
        $game->initGame();
        $session->set("currentgame", $game);

        return $this->redirectToRoute('game_play');
    }

    // Play Game Route
    #[Route("game/gameplay", name: "game_play")]
    public function gamePlay(
        SessionInterface $session
    ): Response {

        $game = $session->get("currentgame");
        $data = $game->playGame($session);
        $session->set("currentgame", $game);

        return $this->render('game/gameplay.html.twig', $data);
    }

    // Game Draw a card Route
    #[Route("game/gamedrawcard", name: "game_drawcard")]
    public function gameDrawCard(
        SessionInterface $session
    ): Response {

        $game = $session->get("currentgame");
        $game->drawCard();
        $session->set("currentgame", $game);

        return $this->redirectToRoute('game_play');
    }

    // Game Pass Route
    #[Route("game/gamepass", name: "game_pass")]
    public function gamePass(
        SessionInterface $session
    ): Response {
        $game = $session->get("currentgame");
        $game->pass();
        $session->set("currentgame", $game);

        return $this->redirectToRoute('game_play');
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Card\DeckOfCards;
use App\Card\CardHand;
use App\Game\CardGame;

class GameController extends AbstractController
{
    #[Route("/game", name: "game", methods:["GET", "POST"])]
    public function gameLandingPage(Request $request): Response
    {
        // https://www.w3schools.com/php/php_superglobals_request.asp
        if ($request->getMethod() === "POST") {
            return $this->redirectToRoute('game_play');
        }

        return $this->render('game_landing.html.twig');


    }

    private function getGameFromSession(SessionInterface $session): ?CardGame
    {
        $fromSession = $session->get("current_game");

        if (is_string($fromSession)) {
            $fromSession = unserialize($fromSession);
        }

        if ($fromSession instanceof CardGame) {
            return $fromSession;
        }

        return null;
    }


    #[Route("/game/play", name: "game_play", methods:["GET", "POST"])]
    public function playGame(SessionInterface $session, Request $request): Response
    {
        if ($request->getMethod() === "GET") {
            return $this->gameGetRequest($session);
        }

        if ($request->getMethod() === "POST") {
            return $this->gamePostRequest($session, $request);
        }

        return $this->render('game_play_banks_turn.html.twig');
    }

    private function gameGetRequest(SessionInterface $session): Response
    {
        $session->clear();
        $theGame = new CardGame();
        $session->set("current_game", serialize($theGame));
        $currentPlayer = "Ditt";

        $data = [
            "player_hand_array" => $theGame->playerHand->getAsString(),
            "current_total_points" => $theGame->playerHand->getTotalNumericalValue(),
            "player_hand_object" => $theGame->playerHand,
            "current_player" => $currentPlayer,
            "player_wins" => $theGame->didPlayerWin(),
            "bank_wins" => $theGame->didBankWin(),
            "banks_turn" => false
        ];

        return $this->render('game_play_players_turn.html.twig', $data);
    }

    private function gamePostRequest(SessionInterface $session, Request $request): Response
    {
        $theGame = $this->getGameFromSession($session);
        $currentPlayer = "Ditt";

        if (!$theGame) {
            return $this->render('game_play_banks_turn.html.twig');
        }

        $playersTurn = $this->handlePlayerActions($theGame, $request);

        if ($playersTurn) {
            return $this->renderPlayersTurn($theGame, $session, $currentPlayer);
        }

        return $this->renderBanksTurn($theGame, $session, $currentPlayer);
    }


    private function handlePlayerActions(CardGame $game, Request $request): bool
    {
        if ($game->playerHand->getTotalNumericalValue() === 21) {
            $game->banksTurn();
            return false;
        }

        if ($request->request->get('one_more_card')) {
            $game->addOneMoreCardToPlayerHand();
            if ($game->playerHand->getTotalNumericalValue() === 21) {
                $game->banksTurn();
                return false;
            }
            return true;
        }

        if ($request->request->get('enough')) {
            $game->banksTurn();
            return false;
        }

        $game->banksTurn();
        return false;
    }


    private function renderPlayersTurn(CardGame $game, SessionInterface $session, string $currentPlayer): Response
    {
        if ($game->playerHand->getTotalNumericalValue() > 21) {
            $game->evaluateWinner();
        }

        $session->set("current_game", serialize($game));

        return $this->render('game_play_players_turn.html.twig', [
            "player_hand_array" => $game->playerHand->getAsString(),
            "current_total_points" => $game->playerHand->getTotalNumericalValue(),
            "player_hand_object" => $game->playerHand,
            "current_player" => $currentPlayer,
            "player_wins" => $game->didPlayerWin(),
            "bank_wins" => $game->didBankWin(),
            "banks_turn" => false
        ]);
    }

    private function renderBanksTurn(CardGame $game, SessionInterface $session, string $currentPlayer): Response
    {
        $session->set("current_game", serialize($game));

        return $this->render('game_play_banks_turn.html.twig', [
            "player_hand_array" => $game->playerHand->getAsString(),
            "current_total_points" => $game->playerHand->getTotalNumericalValue(),
            "player_hand_object" => $game->playerHand,
            "current_player" => $currentPlayer,
            "bank_hand_array" => $game->bankHand->getAsString(),
            "current_total_points_bank" => $game->bankHand->getTotalNumericalValue(),
            "bank_hand_object" => $game->bankHand,
            "player_wins" => $game->didPlayerWin(),
            "bank_wins" => $game->didBankWin(),
            "banks_turn" => true
        ]);
    }


    #[Route("/game/doc", name: "game_doc")]
    public function gameDoc(): Response
    {
        return $this->render('game_doc.html.twig');

    }
}

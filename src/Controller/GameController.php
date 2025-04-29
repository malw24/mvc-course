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
    public function gameLandingPage(): Response
    {
        // https://www.w3schools.com/php/php_superglobals_request.asp
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            return $this->redirectToRoute('game_play');
        } 

        return $this->render('game_landing.html.twig');
       

    }


    #[Route("/game/play", name: "game_play", methods:["GET", "POST"])]
    public function gamePlay(SessionInterface $session, Request $request): Response
    {
        // https://www.w3schools.com/php/php_superglobals_request.asp
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        
        if ($requestMethod === "GET") {
            $session->clear();
            $theGame = new CardGame();
            $session->set("current_game", serialize($theGame));
            $playersTurn = true;
        }
        // Linten klagar på att $theGame kanske inte alltid är definerad men på sättet som jag
        // har satt ihop detta på så går det endast att göra en POST-förfrågan när spelet är igång,
        // och spelet börjar alltid med en GET, så $theGame kommer alltid vara definerad
        if ($requestMethod === "POST" || $theGame->playerHand->getTotalNumericalValue() === 21) {
            $theGame = unserialize($session->get("current_game"));
            if ($request->request->get('one_more_card')) {

                $theGame->addOneMoreCardToPlayerHand();
                $session->set("current_game", serialize($theGame));
                $playersTurn = true;
                if ($theGame->playerHand->getTotalNumericalValue() === 21) {

                    $theGame->banksTurn();
                    $playersTurn = false;
                }
            }
            
            if ($request->request->get('enough')) {
                $theGame->banksTurn();
                $playersTurn = false;
            } 
            
            if (!$request->request->get('one_more_card') && !$request->request->get('enough')) {
                $theGame->banksTurn();
                $playersTurn = false;
            }
        }

        $currentPlayer = "Ditt";


        if ($playersTurn) {
            if ($theGame->playerHand->getTotalNumericalValue() > 21) {
                $theGame->evaluateWinner();
            }
            $data = [
                "player_hand_array" => $theGame->playerHand->getAsString(),
                "current_total_points" => $theGame->playerHand->getTotalNumericalValue(),
                "player_hand_object" => $theGame->playerHand,
                "current_player" => $currentPlayer,
                "player_wins" => $theGame->didPlayerWin(),
                "bank_wins" => $theGame->didBankWin(),
                "banks_turn" => false
            ];
            $session->set("current_game", serialize($theGame));
            return $this->render('game_play_players_turn.html.twig', $data);
        }

        $data = [
            "player_hand_array" => $theGame->playerHand->getAsString(),
            "current_total_points" => $theGame->playerHand->getTotalNumericalValue(),
            "player_hand_object" => $theGame->playerHand,
            "current_player" => $currentPlayer,
            "bank_hand_array" => $theGame->bankHand->getAsString(),
            "current_total_points_bank" => $theGame->bankHand->getTotalNumericalValue(),
            "bank_hand_object" => $theGame->bankHand,
            "player_wins" => $theGame->didPlayerWin(),
            "bank_wins" => $theGame->didBankWin(),
            "banks_turn" => true
        ];
        $session->set("current_game", serialize($theGame));
        return $this->render('game_play_banks_turn.html.twig', $data);

    }

    #[Route("/game/doc", name: "game_doc")]
    public function gameDoc(): Response
    {
        return $this->render('game_doc.html.twig');

    }
}

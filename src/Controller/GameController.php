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
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            return $this->redirectToRoute('game_play');
        } else {
            return $this->render('game_landing.html.twig');
        }
        
    }


    #[Route("/game/play", name: "game_play", methods:["GET", "POST"])]
    public function gamePlay(SessionInterface $session, Request $request): Response
    {
        // https://www.w3schools.com/php/php_superglobals_request.asp
        $request_method = $_SERVER["REQUEST_METHOD"];
        
    
        if($request_method === "GET") {
            $session->clear();
            $the_game = new CardGame();
            $session->set("current_game", serialize($the_game));
            $players_turn = true;
       
        }
     
        if($request_method === "POST" || $the_game->player_hand->getTotalNumericalValue() === 21) {
     
            $the_game = unserialize($session->get("current_game"));
            if($request->request->get('one_more_card')){
          
                $the_game->addOneMoreCardToPlayerHand();
                $session->set("current_game", serialize($the_game));
                $players_turn = true;
                if($the_game->player_hand->getTotalNumericalValue() === 21) {
                
                    $the_game->banksTurn();
                    $players_turn = false;
                }
            } 
            elseif ($request->request->get('enough')) {
             
                $the_game->banksTurn();
                $players_turn = false;
            } else {
                $the_game->banksTurn();
                $players_turn = false;
            }
        }

        $current_player = "Ditt";
      
 
        if($players_turn) {
            $data = [
                "player_hand_array" => $the_game->player_hand->getAsString(),
                "current_total_points" =>$the_game->player_hand->getTotalNumericalValue(),
                "player_hand_object" => $the_game->player_hand,
                "current_player" => $current_player,
                "player_wins" => $the_game->didPlayerWin(),
                "bank_wins" => $the_game->didBankWin(),
                "banks_turn" => false
            ];
            return $this->render('game_play_players_turn.html.twig', $data);
        } else {
            $data = [
                "player_hand_array" => $the_game->player_hand->getAsString(),
                "current_total_points" =>$the_game->player_hand->getTotalNumericalValue(),
                "player_hand_object" => $the_game->player_hand,
                "current_player" => $current_player,
                "bank_hand_array" => $the_game->bank_hand->getAsString(),
                "current_total_points_bank" =>$the_game->bank_hand->getTotalNumericalValue(),
                "bank_hand_object" => $the_game->bank_hand,
                "player_wins" => $the_game->didPlayerWin(),
                "bank_wins" => $the_game->didBankWin(),
                "banks_turn" => true
            ];
            return $this->render('game_play_banks_turn.html.twig', $data);
        }
        


        
    }

    #[Route("game/doc", name: "game_doc")]
    public function shuffleDeck(): Response
    {
        return $this->render('game_doc.html.twig');

    }
}
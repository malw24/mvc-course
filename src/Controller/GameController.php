<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Card\DeckOfCards;

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


    #[Route("/game/play", name: "game_play")]
    public function gamePlay(): Response
    {
        
        return $this->render('game_play.html.twig');
    }

    #[Route("game/doc", name: "game_doc")]
    public function shuffleDeck(): Response
    {
        return $this->render('game_doc.html.twig');

    }
}
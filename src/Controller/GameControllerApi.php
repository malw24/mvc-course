<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Card\DeckOfCards;

class GameControllerApi extends AbstractController
{
    #[Route("/api/game", name: "api_game")]
    public function apiGame(SessionInterface $session): Response
    {
        $session_dump = unserialize($session->get("current_game"));
        if($session_dump) {
            $response = new Response();
            $response->setContent(json_encode($session_dump, JSON_UNESCAPED_UNICODE));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else {
            $message = "No game currently going on.";
            $response = new Response();
            $response->setContent(json_encode($message, JSON_UNESCAPED_UNICODE));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }

}
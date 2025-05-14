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
        $fromSession = $session->get("current_game");
        //https://www.w3schools.com/php/func_var_is_string.asp
        if (is_string($fromSession)) {
            $sessionGet = unserialize($fromSession);
            if ($sessionGet) {

                $response = new JsonResponse($sessionGet);

                $response->setEncodingOptions(
                    $response->getEncodingOptions() | JSON_PRETTY_PRINT
                );
                return $response;
            }
        }
        if (!is_string($fromSession)) {
            $fromSession = null;
        }

        $message = "No game currently going on.";

        $response = new JsonResponse($message);

        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;

    }

}

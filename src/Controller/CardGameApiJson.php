<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Card\DeckOfCards;

class CardGameApiJson extends AbstractController
{
    #[Route("/api/deck", name: "api_deck")]
    public function apiDeck(SessionInterface $session): Response
    {
        if (count($session->all()) === 0) {
            $deckOfCards = new DeckOfCards();
            $deckOfCardsAsArray = $deckOfCards->sortTheCurrentDeck();

            $stringOrFalse = json_encode($deckOfCardsAsArray, JSON_UNESCAPED_UNICODE);
            if ($stringOrFalse === false) {
                $stringOrFalse = '{"error": "Error"}';
            }

            $response = new Response();
            $response->setContent($stringOrFalse);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        $fromSession = $session->get("deck_of_cards");
        if (is_string($fromSession)) {
            $deckOfCards = unserialize($fromSession);
            if ($deckOfCards instanceof DeckOfCards) {
                $deckOfCardsAsArray = $deckOfCards->sortTheCurrentDeck();

                $stringOrFalse = json_encode($deckOfCardsAsArray, JSON_UNESCAPED_UNICODE);
                if ($stringOrFalse === false) {
                    $stringOrFalse = '{"error": "Error"}';
                }

                $response = new Response();
                $response->setContent($stringOrFalse);
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }
        }
        $response = new Response();
        return $response;

    }

    #[Route("/api/deck/shuffle", name: "api_deck_shuffle", methods: ['GET', 'POST'])]
    public function apiDeckShuffle(SessionInterface $session): Response
    {
        $deckOfCards = new DeckOfCards();
        $deckOfCards->shuffledTheDeck();
        $deckOfCardsAsArray = $deckOfCards->getAsString();

        $session->set("deck_of_cards", serialize($deckOfCards));
        $stringOrFalse = json_encode($deckOfCardsAsArray, JSON_UNESCAPED_UNICODE);
        if ($stringOrFalse === false) {
            $stringOrFalse = '{"error": "Error"}';
        }

        $response = new Response();
        $response->setContent($stringOrFalse);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    #[Route("api/deck/draw", name: "api_deck_draw", methods: ['GET', 'POST'])]
    public function apiDeckDraw(SessionInterface $session): Response
    {
        // https://www.w3schools.com/php/func_var_unserialize.asp
        $fromSession = $session->get("deck_of_cards");
        $sessionDeck = "";
        if (is_string($fromSession)) {
            $sessionDeck = unserialize($fromSession);
        }

        if ($sessionDeck) {
            if ($sessionDeck instanceof DeckOfCards) {
                if ($sessionDeck->getTheAmountOfCards() > 0) {
                    // $deckOfCards = unserialize($session->get("deck_of_cards"));
                    $randomCard = $sessionDeck->getRandomCard();
                    $session->set("deck_of_cards", serialize($sessionDeck));

                    $data = [
                        "drawn_card" => $randomCard,
                        "cards_left_in_deck" => $sessionDeck->getTheAmountOfCards()
                    ];

                    $stringOrFalse = json_encode($data, JSON_UNESCAPED_UNICODE);
                    if ($stringOrFalse === false) {
                        $stringOrFalse = '{"error":"Error"}';
                    }


                    $response = new Response();
                    $response->setContent($stringOrFalse);
                    $response->headers->set('Content-Type', 'application/json');
                    return $response;
                }
            }


            $deckOfCards = new DeckOfCards();
            $randomCard = $deckOfCards->getRandomCard();
            $session->set("deck_of_cards", serialize($deckOfCards));

            $data = [
                "drawn_card" => $randomCard,
                "cards_left_in_deck" => $deckOfCards->getTheAmountOfCards()
            ];

            $stringOrFalse = json_encode($data, JSON_UNESCAPED_UNICODE);
            if ($stringOrFalse === false) {
                $stringOrFalse = '{"error":"Error"}';
            }


            $response = new Response();
            $response->setContent($stringOrFalse);
            $response->headers->set('Content-Type', 'application/json');
            return $response;


        }

        $deckOfCards = new DeckOfCards();
        $randomCard = $deckOfCards->getRandomCard();
        $session->set("deck_of_cards", serialize($deckOfCards));

        $data = [
            "drawn_card" => $randomCard,
            "cards_left_in_deck" => $deckOfCards->getTheAmountOfCards()
        ];

        $stringOrFalse = json_encode($data, JSON_UNESCAPED_UNICODE);
        if ($stringOrFalse === false) {
            $stringOrFalse = '{"error":"Error"}';
        }


        $response = new Response();
        $response->setContent($stringOrFalse);
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

    public function apiDeckDrawAmountNew(int $num, SessionInterface $session): Response
    {
        $deckOfCards = new DeckOfCards();
        $drawnCards = [];
        for ($counter = 1; $counter <= $num; $counter++) {
            $randomCard = $deckOfCards->getRandomCard();
            $drawnCards[] = $randomCard;
        }
        $session->set("deck_of_cards", serialize($deckOfCards));

        $data = [
            "drawn_cards" => $drawnCards,
            "cards_left_in_deck" => $deckOfCards->getTheAmountOfCards()
        ];
        $stringOrFalse = json_encode($data, JSON_UNESCAPED_UNICODE);
        if ($stringOrFalse === false) {
            $stringOrFalse = '{"error":"Error"}';
        }

        $response = new Response();
        $response->setContent($stringOrFalse);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    #[Route("api/deck/draw/{num<\d+>}", name: "api_deck_draw_amount", methods: ['GET', 'POST'])]
    public function apiDeckDrawAmount(int $num, SessionInterface $session, Request $request): Response
    {
        if ($request->request->get('num_cards')) {
            $num = $request->request->get('num_cards');
        }
        $fromSession = $session->get("deck_of_cards");
        $sessionDeck = "";
        if (is_string($fromSession)) {
            $sessionDeck = unserialize($fromSession);
        }
        if ($sessionDeck) {
            if ($sessionDeck instanceof DeckOfCards) {
                if ($sessionDeck->getTheAmountOfCards() >= $num) {
                    $drawnCards = [];
                    for ($counter = 1; $counter <= $num; $counter++) {
                        $randomCard = $sessionDeck->getRandomCard();
                        $drawnCards[] = $randomCard;
                    }
                    $session->set("deck_of_cards", serialize($sessionDeck));
                    $data = [
                        "drawn_cards" => $drawnCards,
                        "cards_left_in_deck" => $sessionDeck->getTheAmountOfCards()
                    ];

                    $stringOrFalse = json_encode($data, JSON_UNESCAPED_UNICODE);
                    if ($stringOrFalse === false) {
                        $stringOrFalse = '{"error":"Error"}';
                    }

                    $response = new Response();
                    $response->setContent($stringOrFalse);
                    $response->headers->set('Content-Type', 'application/json');
                    return $response;
                }
            }

            


        }

        return $this->apiDeckDrawAmountNew($num, $session);



    }

   
}

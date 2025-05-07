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
        // https://github.com/symfony/symfony/blob/6.4/src/Symfony/Component/HttpFoundation/Session/SessionInterface.php
        if (count($session->all()) == 0) {
            $deckOfCards = new DeckOfCards();
            $deckOfCardsAsArray = $deckOfCards->sortTheCurrentDeck();
            $response = new Response();
            $response->setContent(json_encode($deckOfCardsAsArray, JSON_UNESCAPED_UNICODE));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        $deckOfCards = unserialize($session->get("deck_of_cards"));


        $deckOfCardsAsArray = $deckOfCards->sortTheCurrentDeck();

        $response = new Response();
        $response->setContent(json_encode($deckOfCardsAsArray, JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "api_deck_shuffle", methods: ['GET', 'POST'])]
    public function apiDeckShuffle(SessionInterface $session): Response
    {
        $deckOfCards = new DeckOfCards();
        $deckOfCards->shuffledTheDeck();
        $deckOfCardsAsArray = $deckOfCards->getAsString();

        $session->set("deck_of_cards", serialize($deckOfCards));

        $response = new Response();
        $response->setContent(json_encode($deckOfCardsAsArray, JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    #[Route("api/deck/draw", name: "api_deck_draw", methods: ['GET', 'POST'])]
    public function apiDeckDraw(SessionInterface $session): Response
    {
        // https://www.w3schools.com/php/func_var_unserialize.asp
        $sessionDeck = unserialize($session->get("deck_of_cards"));
        if ($sessionDeck) {

            if ($sessionDeck->getTheAmountOfCards() > 0) {
                $deckOfCards = unserialize($session->get("deck_of_cards"));
                $randomCard = $deckOfCards->getRandomCard();
                $session->set("deck_of_cards", serialize($deckOfCards));

                $data = [
                    "drawn_card" => $randomCard,
                    "cards_left_in_deck" => $deckOfCards->getTheAmountOfCards()
                ];


                $response = new Response();
                $response->setContent(json_encode($data, JSON_UNESCAPED_UNICODE));
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


            $response = new Response();
            $response->setContent(json_encode($data, JSON_UNESCAPED_UNICODE));
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


        $response = new Response();
        $response->setContent(json_encode($data, JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

    #[Route("api/deck/draw/{num<\d+>}", name: "api_deck_draw_amount", methods: ['GET', 'POST'])]
    public function apiDeckDrawAmount(int $num, SessionInterface $session, Request $request): Response
    {
        if ($request->request->get('num_cards')) {
            $num = $request->request->get('num_cards');
        }
        // https://www.w3schools.com/php/func_var_unserialize.asp
        $sessionDeck = unserialize($session->get("deck_of_cards"));
        if ($sessionDeck) {

            if ($sessionDeck->getTheAmountOfCards() >= $num) {
                $deckOfCards = unserialize($session->get("deck_of_cards"));
                ;
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


                $response = new Response();
                $response->setContent(json_encode($data, JSON_UNESCAPED_UNICODE));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }
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


            $response = new Response();
            $response->setContent(json_encode($data, JSON_UNESCAPED_UNICODE));
            $response->headers->set('Content-Type', 'application/json');
            return $response;


        }

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


        $response = new Response();
        $response->setContent(json_encode($data, JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-Type', 'application/json');
        return $response;



    }


}

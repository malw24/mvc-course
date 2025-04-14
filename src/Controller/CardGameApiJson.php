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
    public function apiDeck(): Response
    {
        $deck_of_cards = new DeckOfCards();

        $deck_of_cards_as_array = $deck_of_cards->getString();

        $response = new Response();
        $response->setContent(json_encode($deck_of_cards_as_array, JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "api_deck_shuffle", methods: ['GET', 'POST'])]
    public function apiDeckShuffle(SessionInterface $session): Response
    {
        $deck_of_cards = new DeckOfCards();
        $deck_of_cards->shuffledTheDeck();
        $deck_of_cards_as_array = $deck_of_cards->getString();

        $session->set("deck_of_cards", serialize($deck_of_cards));

        $response = new Response();
        $response->setContent(json_encode($deck_of_cards_as_array, JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    #[Route("api/deck/draw", name: "api_deck_draw", methods: ['GET', 'POST'])]
    public function apiDeckDraw(SessionInterface $session): Response
    {
        // https://www.w3schools.com/php/func_var_unserialize.asp
        $session_deck = unserialize($session->get("deck_of_cards"));
        if ($session_deck) {

            if ($session_deck->getTheAmountOfCards() > 0) {
                $deck_of_cards = unserialize($session->get("deck_of_cards"));
                ;
                $random_card = $deck_of_cards->getRandomCard();
                $session->set("deck_of_cards", serialize($deck_of_cards));

                $data = [
                    "drawn_card" => $random_card,
                    "cards_left_in_deck" => $deck_of_cards->getTheAmountOfCards()
                ];


                $response = new Response();
                $response->setContent(json_encode($data, JSON_UNESCAPED_UNICODE));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            } else {
                $deck_of_cards = new DeckOfCards();
                $random_card = $deck_of_cards->getRandomCard();
                $session->set("deck_of_cards", serialize($deck_of_cards));

                $data = [
                    "drawn_card" => $random_card,
                    "cards_left_in_deck" => $deck_of_cards->getTheAmountOfCards()
                ];


                $response = new Response();
                $response->setContent(json_encode($data, JSON_UNESCAPED_UNICODE));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }

        } else {

            $this->addFlash(
                'notice',
                'There was no deck in the session, a new deck has been added to the session! Try again!'
            );
            return $this->redirectToRoute('card_deck_shuffle');
        }


    }






    #[Route("api/deck/draw/{num<\d+>}", name: "api_deck_draw_amount", methods: ['GET', 'POST'])]
    public function apiDeckDrawAmount(int $num, SessionInterface $session, Request $request): Response
    {
        if ($request->request->get('num_cards')) {
            $num = $request->request->get('num_cards');
        }
        // https://www.w3schools.com/php/func_var_unserialize.asp
        $session_deck = unserialize($session->get("deck_of_cards"));
        if ($session_deck) {

            if ($session_deck->getTheAmountOfCards() >= $num) {
                $deck_of_cards = unserialize($session->get("deck_of_cards"));
                ;
                $drawnCards = [];
                for ($counter = 1; $counter <= $num; $counter++) {
                    $random_card = $deck_of_cards->getRandomCard();
                    $drawnCards[] = $random_card;
                }
                $session->set("deck_of_cards", serialize($deck_of_cards));
                $data = [
                    "drawn_cards" => $drawnCards,
                    "cards_left_in_deck" => $deck_of_cards->getTheAmountOfCards()
                ];


                $response = new Response();
                $response->setContent(json_encode($data, JSON_UNESCAPED_UNICODE));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            } else {
                $deck_of_cards = new DeckOfCards();
                $drawnCards = [];
                for ($counter = 1; $counter <= $num; $counter++) {
                    $random_card = $deck_of_cards->getRandomCard();
                    $drawnCards[] = $random_card;
                }
                $session->set("deck_of_cards", serialize($deck_of_cards));

                $data = [
                    "drawn_cards" => $drawnCards,
                    "cards_left_in_deck" => $deck_of_cards->getTheAmountOfCards()
                ];


                $response = new Response();
                $response->setContent(json_encode($data, JSON_UNESCAPED_UNICODE));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }

        } else {

            $this->addFlash(
                'notice',
                'There was no deck in the session, a new deck has been added to the session! Try again!'
            );
            return $this->redirectToRoute('card_deck_shuffle');
        }


    }


}

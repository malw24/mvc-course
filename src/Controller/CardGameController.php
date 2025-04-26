<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Card\DeckOfCards;

class CardGameController extends AbstractController
{
    #[Route("/session", name: "session")]
    public function sessionPrint(SessionInterface $session): Response
    {
        $session_content = $session;
        $data = [
            "session_info" => $session_content
        ];
        return $this->render('session.html.twig', $data);
    }

    #[Route("/session/delete", name: "session_delete")]
    public function sessionClear(SessionInterface $session): Response
    {
        // Jag vet inte om denna dokumentationen är okej att använda? Jag googlade "symfony sessionInterface"
        // https://github.com/symfony/symfony/blob/6.4/src/Symfony/Component/HttpFoundation/Session/SessionInterface.php
        $session_content = $session->clear();

        $this->addFlash(
            'notice',
            'The data in session has been deleted!'
        );

        return $this->redirectToRoute('session');
    }

    #[Route("/card", name: "card")]
    public function cardLandingPage(): Response
    {
        return $this->render('card_landing.html.twig');
    }

    #[Route("/card/deck", name: "card_deck")]
    public function cardDeck(SessionInterface $session): Response
    {
        $deck_of_cards = unserialize($session->get("deck_of_cards"));
        if(!$deck_of_cards) {
            $deck_of_cards = new DeckOfCards();
            // https://www.w3schools.com/php/func_var_serialize.asp
            $session->set("deck_of_cards", serialize($deck_of_cards));
        }
       
        
        $sorted_deck_as_array = $deck_of_cards->sortTheCurrentDeck();

        $data = [
            "deck_as_array" => $sorted_deck_as_array
        ];
        return $this->render('write_out_current_deck.html.twig', $data);

    }

    #[Route("card/deck/shuffle", name: "card_deck_shuffle")]
    public function shuffleDeck(SessionInterface $session): Response
    {
        $deck_of_cards = new DeckOfCards();
        $deck_of_cards->shuffledTheDeck();
        // https://www.w3schools.com/php/func_var_serialize.asp
        $session->set("deck_of_cards", serialize($deck_of_cards));
        // var_dump($session);
        $deck_of_cards = $deck_of_cards->getWholeDeckAsArray();
        // var_dump($deck_of_cards);
        $data = [
            "deck_of_cards" => $deck_of_cards
        ];
        return $this->render('shuffled_deck.html.twig', $data);

    }

    #[Route("/card/deck/draw", name: "card_deck_draw")]
    public function drawRandomCardDeck(SessionInterface $session): Response
    {
        // https://www.w3schools.com/php/func_var_unserialize.asp
        $session_deck = unserialize($session->get("deck_of_cards"));
        if ($session_deck) {
            if ($session_deck->getTheAmountOfCards() > 0) {
                // https://www.w3schools.com/php/func_var_unserialize.asp
                $deck_of_cards = unserialize($session->get("deck_of_cards"));
                $random_card = $deck_of_cards->getRandomCard();
                $amount_of_cards_left = $deck_of_cards->getTheAmountOfCards();
                $session->set("deck_of_cards", serialize($deck_of_cards));
                $data = [
                    "random_card" => $random_card,
                    "amount_of_cards_left" => $amount_of_cards_left
                ];
                return $this->render('draw_random_card.html.twig', $data);

            } else {
                $deck_of_cards = new DeckOfCards();
                $random_card = $deck_of_cards->getRandomCard();
                $amount_of_cards_left = $deck_of_cards->getTheAmountOfCards();
                // https://www.w3schools.com/php/func_var_serialize.asp
                $session->set("deck_of_cards", serialize($deck_of_cards));
                $data = [
                    "random_card" => $random_card,
                    "amount_of_cards_left" => $amount_of_cards_left
                ];
                return $this->render('draw_random_card.html.twig', $data);
            }
        } else {
            $deck_of_cards = new DeckOfCards();
            $random_card = $deck_of_cards->getRandomCard();
            $amount_of_cards_left = $deck_of_cards->getTheAmountOfCards();
            // https://www.w3schools.com/php/func_var_serialize.asp
            $session->set("deck_of_cards", serialize($deck_of_cards));
            $data = [
                "random_card" => $random_card,
                "amount_of_cards_left" => $amount_of_cards_left
            ];
            return $this->render('draw_random_card.html.twig', $data);
        }



    }

    #[Route("card/deck/draw/{num<\d+>}", name: "deck_draw_num_cards")]
    public function drawAmountOfCards(int $num, SessionInterface $session, Request $request): Response
    {

        if ($request->request->get('num_cards')) {
            $num = $request->request->get('num_cards');
        }
        if ($num > 52) {
            throw new \Exception("Can not draw more then 52 cards!");
        }

        // https://www.w3schools.com/php/func_var_unserialize.asp
        $session_deck = unserialize($session->get("deck_of_cards"));
        if ($session_deck) {
            if ($session_deck->getTheAmountOfCards() >= $num) {
                // https://www.w3schools.com/php/func_var_unserialize.asp
                $deck_of_cards =  unserialize($session->get("deck_of_cards"));
                $drawnCards = [];
                for ($counter = 1; $counter <= $num; $counter++) {
                    $random_card = $deck_of_cards->getRandomCard();
                    $drawnCards[] = $random_card;
                }
                $session->set("deck_of_cards", serialize($deck_of_cards));
                $data = [
                    "num_cards_left" => $deck_of_cards->getTheAmountOfCards(),
                    "drawnCards" => $drawnCards,
                    "requested_amount" => $num
                ];

                return $this->render('draw_many.html.twig', $data);

            } else {
                $deck_of_cards = new DeckOfCards();
                $drawnCards = [];
                for ($counter = 1; $counter <= $num; $counter++) {
                    $random_card = $deck_of_cards->getRandomCard();
                    $drawnCards[] = $random_card;
                }
                $session->set("deck_of_cards", serialize($deck_of_cards));
                $data = [
                    "num_cards_left" => $deck_of_cards->getTheAmountOfCards(),
                    "drawnCards" => $drawnCards,
                    "requested_amount" => $num
                ];

                return $this->render('draw_many.html.twig', $data);

            }



        } else {
            $deck_of_cards = new DeckOfCards();
            $drawnCards = [];
            for ($counter = 1; $counter <= $num; $counter++) {
                $random_card = $deck_of_cards->getRandomCard();
                $drawnCards[] = $random_card;
            }
            $session->set("deck_of_cards", serialize($deck_of_cards));
            $data = [
                "num_cards_left" => $deck_of_cards->getTheAmountOfCards(),
                "drawnCards" => $drawnCards,
                "requested_amount" => $num
            ];

            return $this->render('draw_many.html.twig', $data);
        }



    }

   


}

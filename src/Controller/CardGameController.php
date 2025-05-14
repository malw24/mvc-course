<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Card\DeckOfCards;
use Exception;

class CardGameController extends AbstractController
{
    #[Route("/session", name: "session")]
    public function sessionPrint(SessionInterface $session): Response
    {
        $sessionContent = $session;
        $data = [
            "session_info" => $sessionContent
        ];
        return $this->render('session.html.twig', $data);
    }

    #[Route("/session/delete", name: "session_delete")]
    public function sessionClear(SessionInterface $session): Response
    {
        // Jag vet inte om denna dokumentationen är okej att använda? Jag googlade "symfony sessionInterface"
        // https://github.com/symfony/symfony/blob/6.4/src/Symfony/Component/HttpFoundation/Session/SessionInterface.php
        $session->clear();

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

        $deckOfCards = "";
        $fromSession = $session->get("deck_of_cards");
        if (is_string($fromSession)) {
            $deckOfCards = unserialize($fromSession);
        }

        if (!$deckOfCards) {
            $deckOfCards = new DeckOfCards();
            // https://www.w3schools.com/php/func_var_serialize.asp
            $session->set("deck_of_cards", serialize($deckOfCards));
        }

        if ($deckOfCards instanceof DeckOfCards) {
            $sortedDeckAsArray = $deckOfCards->sortTheCurrentDeck();

            $data = [
                "deck_as_array" => $sortedDeckAsArray
            ];
            return $this->render('write_out_current_deck.html.twig', $data);
        }
        return $this->render('write_out_current_deck.html.twig');

    }

    #[Route("card/deck/shuffle", name: "card_deck_shuffle")]
    public function shuffleDeck(SessionInterface $session): Response
    {
        $deckOfCards = new DeckOfCards();
        $deckOfCards->shuffledTheDeck();
        // https://www.w3schools.com/php/func_var_serialize.asp
        $session->set("deck_of_cards", serialize($deckOfCards));
        // var_dump($session);
        $deckOfCards = $deckOfCards->getWholeDeckAsArray();
        // var_dump($deckOfCards);
        $data = [
            "deck_of_cards" => $deckOfCards
        ];
        return $this->render('shuffled_deck.html.twig', $data);

    }

    #[Route("/card/deck/draw", name: "card_deck_draw")]
    public function drawRandomCardDeck(SessionInterface $session): Response
    {
        $fromSession = $session->get("deck_of_cards");
        $sessionDeck = "";
        if (is_string($fromSession)) {
            $sessionDeck = unserialize($fromSession);
            if ($sessionDeck) {
                if ($sessionDeck instanceof DeckOfCards && $sessionDeck->getTheAmountOfCards() > 0) {
                    // https://www.w3schools.com/php/func_var_unserialize.asp
                    $fromSession = $session->get("deck_of_cards");
                    if (is_string($fromSession)) {
                        $deckOfCards = unserialize($fromSession);
                        if ($deckOfCards instanceof DeckOfCards) {
                            $randomCard = $deckOfCards->getRandomCard();
                            $amountOfCardsLeft = $deckOfCards->getTheAmountOfCards();
                            $session->set("deck_of_cards", serialize($deckOfCards));
                            $data = [
                                "random_card" => $randomCard,
                                "amount_of_cards_left" => $amountOfCardsLeft
                            ];
                            return $this->render('draw_random_card.html.twig', $data);
                        }
                    }
                }

                $deckOfCards = new DeckOfCards();
                $randomCard = $deckOfCards->getRandomCard();
                $amountOfCardsLeft = $deckOfCards->getTheAmountOfCards();
                // https://www.w3schools.com/php/func_var_serialize.asp
                $session->set("deck_of_cards", serialize($deckOfCards));
                $data = [
                    "random_card" => $randomCard,
                    "amount_of_cards_left" => $amountOfCardsLeft
                ];
                return $this->render('draw_random_card.html.twig', $data);

            }
        }
        // https://www.w3schools.com/php/func_var_unserialize.asp
        // $sessionDeck = unserialize($session->get("deck_of_cards"));

        $deckOfCards = new DeckOfCards();
        $randomCard = $deckOfCards->getRandomCard();
        $amountOfCardsLeft = $deckOfCards->getTheAmountOfCards();
        // https://www.w3schools.com/php/func_var_serialize.asp
        $session->set("deck_of_cards", serialize($deckOfCards));
        $data = [
            "random_card" => $randomCard,
            "amount_of_cards_left" => $amountOfCardsLeft
        ];
        return $this->render('draw_random_card.html.twig', $data);




    }

    #[Route("card/deck/draw/{num<\d+>}", name: "deck_draw_num_cards")]
    public function drawAmountOfCards(int $num, SessionInterface $session, Request $request): Response
    {

        if ($request->request->get('num_cards')) {
            $num = $request->request->get('num_cards');
        }
        if ($num > 52) {
            throw new Exception("Can not draw more then 52 cards!");
        }
        // https://www.w3schools.com/php/func_var_unserialize.asp
        $fromSession = $session->get("deck_of_cards");
        if (is_string($fromSession)) {
            $sessionDeck = unserialize($fromSession);
            if ($sessionDeck instanceof DeckOfCards) {
                if ($sessionDeck->getTheAmountOfCards() >= $num) {
                    // https://www.w3schools.com/php/func_var_unserialize.asp
                    $fromSession = $session->get("deck_of_cards");
                    if (is_string($fromSession)) {
                        $deckOfCards =  unserialize($fromSession);
                        if ($deckOfCards instanceof DeckOfCards) {
                            $drawnCards = [];
                            for ($counter = 1; $counter <= $num; $counter++) {
                                $randomCard = $deckOfCards->getRandomCard();
                                $drawnCards[] = $randomCard;
                            }
                            $session->set("deck_of_cards", serialize($deckOfCards));
                            $data = [
                                "num_cards_left" => $deckOfCards->getTheAmountOfCards(),
                                "drawnCards" => $drawnCards,
                                "requested_amount" => $num
                            ];

                            return $this->render('draw_many.html.twig', $data);
                        }
                    }
                }
            }

            $deckOfCards = new DeckOfCards();
            $drawnCards = [];
            for ($counter = 1; $counter <= $num; $counter++) {
                $randomCard = $deckOfCards->getRandomCard();
                $drawnCards[] = $randomCard;
            }
            $session->set("deck_of_cards", serialize($deckOfCards));
            $data = [
                "num_cards_left" => $deckOfCards->getTheAmountOfCards(),
                "drawnCards" => $drawnCards,
                "requested_amount" => $num
            ];

            return $this->render('draw_many.html.twig', $data);

        }

        $deckOfCards = new DeckOfCards();
        $drawnCards = [];
        for ($counter = 1; $counter <= $num; $counter++) {
            $randomCard = $deckOfCards->getRandomCard();
            $drawnCards[] = $randomCard;
        }
        $session->set("deck_of_cards", serialize($deckOfCards));
        $data = [
            "num_cards_left" => $deckOfCards->getTheAmountOfCards(),
            "drawnCards" => $drawnCards,
            "requested_amount" => $num
        ];

        return $this->render('draw_many.html.twig', $data);
    }




}

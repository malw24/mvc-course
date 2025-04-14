<?php

namespace App\Card;

use App\Card\DeckOfCards;

class CardHand
{
    protected $cards = [];

    public function __construct($amount_of_cards)
    {
        $deck_of_cards = new DeckOfCards();
        for ($counter = 0; $counter < $amount_of_cards; $counter++) {
            $this->cards[] = $deck_of_cards->getRandomCard();
        }


    }

    public function getAsString(): string
    {
        $hand = "";
        foreach ($this->cards as $card) {
            $hand .= $card;
        }

        return $hand;
    }

}

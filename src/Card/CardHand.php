<?php

namespace App\Card;

use App\Card\DeckOfCards;

class CardHand
{
    public $cards = [];
    public $deck_of_cards;

    public function __construct($amount_of_cards)
    {
        $this->deck_of_cards = new DeckOfCards();
        $this->deck_of_cards->shuffledTheDeck();
        for ($counter = 0; $counter < $amount_of_cards; $counter++) {
            $this->cards[] = $this->deck_of_cards->getRandomCardAsObject();
        }
        // var_dump($deck_of_cards->getTheAmountOfCards());

    }

    public function returnCurrentDeck(): Object 
    {
        return $this->deck_of_cards;
    }

    public function getAsString(): array
     {
         $cards = [];
         foreach ($this->cards as $card) {
             $cards[] = $card->getAsString();
         } 
         return $cards;
     }

    public function getTotalNumericalValue(): int
    {
        $total = 0;
        foreach($this->cards as $card) {
            $total += $card->numeric_value;
        }
        // var_dump($total);
        return $total;
    }

    // public function getAsString(): string
    // {
    //     $hand = "";
    //     foreach ($this->cards as $card) {
    //         $hand .= $card;
    //     }

    //     return $hand;
    // }

    public function getRandomCard(): string
    {
        $this->cards[] =  $this->$deck_of_cards->getRandomCardAsObject();
    }

}

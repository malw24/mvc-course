<?php

namespace App\Card;


/*

MÅSTE FIXA TILL CardGraphic så att den gör mer nytta!! Tror jag?

Och CardHand är inte klar!


*/
class CardHand
{

    protected $cards = [];

    public function __construct($cards)
    {
        $this->cards = $cards; //Kommer vara en array

    }

    public function getAsString(): string
    {
        foreach($this->cards as $card) {
            return $card;
        }
    }
}
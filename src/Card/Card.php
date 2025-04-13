<?php

namespace App\Card;

/*

MÅSTE FIXA TILL CardGraphic så att den gör mer nytta!! Tror jag?

Och CardHand är inte klar!


*/

class Card
{
    protected $suit;
    protected $value;

    public function __construct($suit, $value)
    {
        $this->suit =  $suit;
        $this->value = $value;
    }

    public function getAsString(): string
    {
        return "[{$this->value}{$this->suit}]";
    }

}
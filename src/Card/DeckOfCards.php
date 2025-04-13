<?php

namespace App\Card;

/*

MÅSTE FIXA TILL CardGraphic så att den gör mer nytta!! Tror jag?

Och CardHand är inte klar!


*/

use App\Card\CardGraphic;

class DeckOfCards
{
    private $deck = [];

    private $suits = [
        '♠',
        '♥',
        '♦',
        '♣',
    ];

    function __construct() {
        // För varje färg
        foreach ($this->suits as $suit) {
            // Lägg till 13 kort
            for ($counter = 2; $counter <= 14; $counter++) {
                $value = $counter;
                // Om korten är 11 eller mer, lägg till klädda kort
                if ($counter == 11) {
                    $value = 'J';
                } 
                if ($counter == 12) {
                    $value = 'Q';
                } 
                if ($counter == 13) {
                    $value = 'K';
                } 
                if ($counter == 14) {
                    $value = 'A';
                } 
                // https://www.w3schools.com/php/php_arrays_add.asp
                $this->deck[] = new CardGraphic($suit, $value);
            }
        }
    }
    
    
    public function getString(): array
    {
        $cards = [];
        foreach ($this->deck as $card) {
            $cards[] = $card->getAsString();
        }
        return $cards;
    }
    
    
    
    
}
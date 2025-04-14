<?php

namespace App\Card;

use App\Card\CardGraphic;

class DeckOfCards
{
    protected $deck = [];


    private $suits = [
        '♠',
        '♥',
        '♦',
        '♣',
    ];

    public function __construct()
    {

        foreach ($this->suits as $suit) {

            for ($counter = 2; $counter <= 14; $counter++) {
                $value = $counter;

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

                $this->deck[] = new CardGraphic($suit, $value);
            }
        }
    }



    public function getRandomCard(): string
    {
        // https://www.w3schools.com/php/func_array_rand.asp
        $random_index = array_rand($this->deck);
        $card = $this->deck[$random_index];
        unset($this->deck[$random_index]);
        return $card->getAsString();
    }

    public function shuffledTheDeck(): array
    {
        // https://www.w3schools.com/Php/func_array_shuffle.asp
        shuffle($this->deck);
        return $this->deck;
    }

    public function getWholeDeckAsArray(): array
    {
        $returned_array = [];
        foreach ($this->deck as $card) {
            $returned_array[] = $card;
        }
        return $returned_array;
    }



    public function getTheAmountOfCards(): int
    {
        $amount_of_cards_left = count($this->deck);
        return $amount_of_cards_left;
    }




}

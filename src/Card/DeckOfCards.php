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

                $this->deck[] = new CardGraphic($suit, $value, $counter);
            }
        }
    }

    public function sortTheCurrentDeck(): array
    {
        $deck_of_cards_as_array = $this->deck;
        foreach($deck_of_cards_as_array as $card) {
            if($card->suit == '♠') {
            $spades_values[] = $card->numeric_value;
            sort($spades_values);
            }
            if($card->suit == '♥') {
                $hearts_values[] = $card->numeric_value;
                sort($hearts_values);
            }
            if($card->suit == '♦') {
                $diamond_values[] = $card->numeric_value;
                sort($diamond_values);
            }
            if($card->suit == '♣') {
                $club_values[] = $card->numeric_value;
                sort($club_values);
            }
        }
      
        //spades
        //https://www.w3schools.com/php/func_var_isset.asp
        if(isset($spades_values)) {
            foreach($spades_values as $spade_card_value) {
                if($spade_card_value == 11) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♠', "J", 11);
                }
                if($spade_card_value == 12) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♠', "Q", 12);
                }
                if($spade_card_value == 13) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♠', "K", 13);
                }
                if($spade_card_value == 14) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♠', "A", 14);
                }
                if($spade_card_value < 11) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♠', $spade_card_value, $spade_card_value);
                }
            }
        }
        
        //hearts
        //https://www.w3schools.com/php/func_var_isset.asp
        if(isset($hearts_values)) {
            foreach($hearts_values as $heart_card_value) {
                if($heart_card_value == 11) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♥', "J", 11);
                }
                if($heart_card_value == 12) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♥', "Q", 12);
                }
                if($heart_card_value == 13) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♥', "K", 13);
                }
                if($heart_card_value == 14) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♥', "A", 14);
                }
                if($heart_card_value < 11) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♥', $heart_card_value, $heart_card_value);
                }
            }
        }
        

        //Diamonds
        //https://www.w3schools.com/php/func_var_isset.asp
        if(isset($diamond_values)) {
            foreach($diamond_values as $diamond_card_value) {
                if($diamond_card_value == 11) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♦', "J", 11);
                }
                if($diamond_card_value == 12) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♦', "Q", 12);
                }
                if($diamond_card_value == 13) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♦', "K", 13);
                }
                if($diamond_card_value == 14) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♦', "A", 14);
                }
                if($diamond_card_value < 11) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♦', $diamond_card_value, $diamond_card_value);
                }
            }
        }
        
        // Clubs
        //https://www.w3schools.com/php/func_var_isset.asp
        if(isset($club_values)) {
            foreach($club_values as $club_card_value) {
                if($club_card_value == 11) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♣', "J", 11);
                }
                if($club_card_value == 12) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♣', "Q", 12);
                }
                if($club_card_value == 13) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♣', "K", 13);
                }
                if($club_card_value == 14) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♣', "A", 14);
                }
                if($club_card_value < 11) {
                    $deck_of_cards_as_array_sorted[] = new CardGraphic('♣', $club_card_value, $club_card_value);
                }
            }
        }
        
      
        return $deck_of_cards_as_array_sorted;
    }

    public function getRandomCard(): string
    {
        // https://www.w3schools.com/php/func_array_rand.asp
        $random_index = array_rand($this->deck);
        $card = $this->deck[$random_index];
        unset($this->deck[$random_index]);
        return $card->getAsString();
    }

    public function getRandomCardAsObject(): Object
    {
        // https://www.w3schools.com/php/func_array_rand.asp
        $random_index = array_rand($this->deck);
        $card = $this->deck[$random_index];
        unset($this->deck[$random_index]);
        return $card;
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

    public function getAsString(): array
     {
         $cards = [];
         foreach ($this->deck as $card) {
             $cards[] = $card->getAsString();
         } 
         return $cards;
     }


    public function getTheAmountOfCards(): int
    {
        $amount_of_cards_left = count($this->deck);
        return $amount_of_cards_left;
    }




}

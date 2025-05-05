<?php

namespace App\Card;

use App\Card\CardGraphic;

class DeckOfCards
{
    protected array $deck = [];


    private array $suits = [
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

    // public function sortSpades() {
        
    // }

    public function sortTheCurrentDeck(): array
    {   
        $deckOfCardsAsArray = $this->deck;
        foreach ($deckOfCardsAsArray as $card) {
            if ($card->suit == '♠') {
                $spadesValues[] = $card->numericValue;
                sort($spadesValues);
            }
            if ($card->suit == '♥') {
                $heartsValues[] = $card->numericValue;
                sort($heartsValues);
            }
            if ($card->suit == '♦') {
                $diamondValues[] = $card->numericValue;
                sort($diamondValues);
            }
            if ($card->suit == '♣') {
                $clubValues[] = $card->numericValue;
                sort($clubValues);
            }
        }

        $deckOfCardsAsArraySorted = [];
        
        //spades
        //https://www.w3schools.com/php/func_var_isset.asp
        if (isset($spadesValues)) {
            foreach ($spadesValues as $spadeCardValue) {
                if ($spadeCardValue == 11) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♠', "J", 11);
                }
                if ($spadeCardValue == 12) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♠', "Q", 12);
                }
                if ($spadeCardValue == 13) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♠', "K", 13);
                }
                if ($spadeCardValue == 14) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♠', "A", 14);
                }
                if ($spadeCardValue < 11) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♠', $spadeCardValue, $spadeCardValue);
                }
            }
        }

        //hearts
        //https://www.w3schools.com/php/func_var_isset.asp
        if (isset($heartsValues)) {
            foreach ($heartsValues as $heartCardValue) {
                if ($heartCardValue == 11) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♥', "J", 11);
                }
                if ($heartCardValue == 12) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♥', "Q", 12);
                }
                if ($heartCardValue == 13) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♥', "K", 13);
                }
                if ($heartCardValue == 14) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♥', "A", 14);
                }
                if ($heartCardValue < 11) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♥', $heartCardValue, $heartCardValue);
                }
            }
        }


        //Diamonds
        //https://www.w3schools.com/php/func_var_isset.asp
        if (isset($diamondValues)) {
            foreach ($diamondValues as $diamondCardValue) {
                if ($diamondCardValue == 11) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♦', "J", 11);
                }
                if ($diamondCardValue == 12) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♦', "Q", 12);
                }
                if ($diamondCardValue == 13) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♦', "K", 13);
                }
                if ($diamondCardValue == 14) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♦', "A", 14);
                }
                if ($diamondCardValue < 11) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♦', $diamondCardValue, $diamondCardValue);
                }
            }
        }

        // Clubs
        //https://www.w3schools.com/php/func_var_isset.asp
        if (isset($clubValues)) {
            foreach ($clubValues as $clubCardValue) {
                if ($clubCardValue == 11) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♣', "J", 11);
                }
                if ($clubCardValue == 12) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♣', "Q", 12);
                }
                if ($clubCardValue == 13) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♣', "K", 13);
                }
                if ($clubCardValue == 14) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♣', "A", 14);
                }
                if ($clubCardValue < 11) {
                    $deckOfCardsAsArraySorted[] = new CardGraphic('♣', $clubCardValue, $clubCardValue);
                }
            }
        }


        return $deckOfCardsAsArraySorted;
    }

    public function getRandomCard(): string
    {
        // https://www.w3schools.com/php/func_array_rand.asp
        $randomIndex = array_rand($this->deck);
        $card = $this->deck[$randomIndex];
        unset($this->deck[$randomIndex]);
        return $card->getAsString();
    }

    public function getRandomCardAsObject(): Object
    {
        // https://www.w3schools.com/php/func_array_rand.asp
        $randomIndex = array_rand($this->deck);
        $card = $this->deck[$randomIndex];
        unset($this->deck[$randomIndex]);
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
        $returnedArray = [];
        foreach ($this->deck as $card) {
            $returnedArray[] = $card;
        }
        return $returnedArray;
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
        $amountOfCardsLeft = count($this->deck);
        return $amountOfCardsLeft;
    }




}

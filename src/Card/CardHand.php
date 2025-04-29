<?php

namespace App\Card;

use App\Card\DeckOfCards;

class CardHand
{
    public array $cards = [];
    public DeckOfCards $deckOfCards;

    public function __construct(int $amountOfCards)
    {
        $this->deckOfCards = new DeckOfCards();
        $this->deckOfCards->shuffledTheDeck();
        for ($counter = 0; $counter < $amountOfCards; $counter++) {
            $this->cards[] = $this->deckOfCards->getRandomCardAsObject();
        }

    }

    public function returnCurrentDeck(): Object
    {
        return $this->deckOfCards;
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
        foreach ($this->cards as $card) {
            $total += $card->numericValue;
        }
        return $total;
    }

    public function getRandomCard(): array
    {
        $this->cards[] =  $this->deckOfCards->getRandomCardAsObject();
        return $this->cards;
    }

}

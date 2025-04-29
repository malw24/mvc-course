<?php

namespace App\Game;

use App\Card\CardHand;
use App\Card\DeckOfCards;

class CardGame
{
    public CardHand $playerHand;
    public CardHand $bankHand;
    public DeckOfCards $theDeck;
    public bool $playerWon = false;
    public bool $bankWon = false;

    public function __construct()
    {
        $this->playerHand = new CardHand(1);
        $this->theDeck = $this->playerHand->deckOfCards;

    }


    public function evaluateWinner(): void
    {
        if ($this->playerHand->getTotalNumericalValue() > 21) {
            $this->bankWon = true;
            return;
        }

        if ($this->bankHand->getTotalNumericalValue() > 21) {
            $this->playerWon = true;
            return;
        }

        if ($this->playerHand->getTotalNumericalValue() > $this->bankHand->getTotalNumericalValue()) {
            $this->playerWon = true;
            return;
        } 
        $this->bankWon = true;
        return;
        
    }

    public function addOneMoreCardToPlayerHand(): void
    {
        $this->playerHand->cards[] = $this->theDeck->getRandomCardAsObject();
    }

    public function banksTurn(): void
    {
        $this->bankHand = new CardHand(0);
        $this->bankHand->deckOfCards = $this->theDeck;
        $this->bankHand->cards[] = $this->theDeck->getRandomCardAsObject();
        $this->bankHand->cards[] = $this->theDeck->getRandomCardAsObject();
        while ($this->bankHand->getTotalNumericalValue() < 17) {
            $this->bankHand->cards[] = $this->theDeck->getRandomCardAsObject();
        }
        $this->evaluateWinner();
    }

    public function didPlayerWin(): bool
    {
        return $this->playerWon;
    }

    public function didBankWin(): bool
    {
        return $this->bankWon;
    }



}

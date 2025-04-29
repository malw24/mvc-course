<?php

namespace App\Game;

use App\Card\CardHand;



class CardGame
{
    public $player_hand;
    public $bank_hand;
    public $the_deck;
    public $playerWon = false;
    public $bankWon = false; 
    
    public function __construct()
    {
        $this->player_hand = new CardHand(1);
        $this->the_deck = $this->player_hand->deck_of_cards;

    }

    public function evaluateWinner() {
        if($this->bank_hand->getTotalNumericalValue() > 21) {
            $this->playerWon = true;

        } else {
            if($this->player_hand->getTotalNumericalValue() > $this->bank_hand->getTotalNumericalValue()) {
                $this->playerWon = true;

            } else {
                $this->bankWon = true;

            }
        }
    }

    public function addOneMoreCardToPlayerHand(){
        $this->player_hand->cards[] = $this->the_deck->getRandomCardAsObject();
    }

    public function banksTurn() {
        $this->bank_hand = new CardHand(0);
        $this->bank_hand->deck_of_cards = $this->the_deck;
        $this->bank_hand->cards[] = $this->the_deck->getRandomCardAsObject();
        $this->bank_hand->cards[] = $this->the_deck->getRandomCardAsObject();
        while ($this->bank_hand->getTotalNumericalValue() < 17) {
            $this->bank_hand->cards[] = $this->the_deck->getRandomCardAsObject();
        }
        $this->evaluateWinner();
   
        

    }

    public function didPlayerWin() {
        return $this->playerWon;
    }

    public function didBankWin() {
        return $this->bankWon;
    }



}
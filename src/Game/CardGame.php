<?php

namespace App\Game;

use App\Card\CardHand;
use App\Card\DeckOfCards;

/**
 * The CardGame class, acting as one round of the game.
 */
class CardGame
{
    /**
     * @var CardHand $playerHand            The instance of the class CardHand acting as the player's hand.
     * @var CardHand $bankHand              The instance of the class CardHand acting as the bank's hand.
     * @var DeckOfCards $theDeck            The instance of the class DeckOfCards acting as the deck.
     * @var bool $playerWon                 The current status of the player winning or not.
     * @var bool $bankWon                   The current status of the bank winning or not.
     */
    public CardHand $playerHand;
    public CardHand $bankHand;
    public DeckOfCards $theDeck;
    public bool $playerWon = false;
    public bool $bankWon = false;

    /**
     * Constructor to initiate the object.
     * This is where the player is dealt one card and the deck variable is assigned its instance of DeckOfCards.
     */
    public function __construct()
    {
        $this->playerHand = new CardHand(1);
        $this->theDeck = $this->playerHand->deckOfCards;

    }

    /**
     * Evaluates who is the winner between the bank and the player.
     * @return void
     */
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

    /**
     * Performs the action of adding one more card to the player's hand.
     * @return void
     */
    public function addOneMoreCardToPlayerHand(): void
    {
        $this->playerHand->cards[] = $this->theDeck->getRandomCardAsObject();
    }

    /**
     * Initiates the bank's turn of the round.
     * @return void
     */
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

    /**
     * Fetches current player's win or lose status.
     * @return bool representing if the player won or lost.
     */
    public function didPlayerWin(): bool
    {
        return $this->playerWon;
    }

    /**
     * Fetches current bank's win or lose status.
     * @return bool representing if the bank won or lost.
     */
    public function didBankWin(): bool
    {
        return $this->bankWon;
    }



}

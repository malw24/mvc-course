<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;
use App\Game\CardGame;
use App\Card\CardHand;
use App\Card\DeckOfCards;

/**
 * Test cases for class CardGame.
 */
class CardGameTest extends TestCase
{
    /**
     * Test that an instance of CardGame is created correctly.
     */
    public function testCreateObject():void
    {
        $cardGame = new CardGame();
        $this->assertInstanceOf("\App\Game\CardGame", $cardGame);
    }

    /**
     * Test that the evaluateWinner method behaves as intended.
     */
    public function testEvaluateWinner():void
    {
        for ($counter = 0; $counter <= 400; $counter++) {

            $cardGame = new CardGame();
            // $card = $cardGame->playerHand->cards[0];
            $cardGame->banksTurn();

            if ($cardGame->playerHand->getTotalNumericalValue() > 21) {
                $this->assertTrue($cardGame->bankWon === true);
                return;

            } elseif ($cardGame->bankHand->getTotalNumericalValue() > 21) {
                $this->assertTrue($cardGame->playerWon === true);
                return;


            } 
            elseif ($cardGame->playerHand->getTotalNumericalValue() > $cardGame->bankHand->getTotalNumericalValue()) {
                $this->assertTrue($cardGame->playerWon === true);
                return;

            }

            $this->assertTrue($cardGame->bankWon === true);

        }

    }

    /**
     * Test that the bank wins when the player busts.
     */
    public function testEvaluateWinnerWhenPlayerHandTooBig():void
    {
        $cardGame = new CardGame();
        $card = $cardGame->playerHand->cards[0];
        $card->numericValue = 24;
        $cardGame->banksTurn();
        $this->assertTrue($cardGame->bankWon === true);
        $this->assertTrue($cardGame->didBankWin() === true);
    }

    /**
     * Test that the player wins when both player and bank are under 21 but the player has a bigger score.
     */
    public function testPlayerWinnerWhenBothAreUnderTwentyOne():void
    {
        for ($counter = 0; $counter <= 100; $counter++) {
            $cardGame = new CardGame();
            $card = $cardGame->playerHand->cards[0];
            $card->numericValue = 20;
            $cardGame->banksTurn();
            if ($cardGame->bankHand->getTotalNumericalValue() < 20) {
                $this->assertTrue($cardGame->playerWon === true);
                $this->assertTrue($cardGame->didPlayerWin() === true);
            }
        }
    }

    /**
     * Test that the testaddOneMoreCardToPlayerHand adds one more card to the player.
     */
    public function testAddOneMoreCardToPlayerHand(): void
    {
        $cardGame = new CardGame();

        $cardGame->addOneMoreCardToPlayerHand();

        $this->assertCount(2, $cardGame->playerHand->cards);
    }

    


}

<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use App\Card\DeckOfCards;
use App\Card\CardHand;
use App\Card\CardGraphic;


/**
 * Test cases for class Card.
 */
class CardHandTest extends TestCase
{
    /**
     * Test that it is an instance of CardHand
     */
    public function testCreateObject()
    {
        $cardHand = new CardHand(7);
        $this->assertInstanceOf("\App\Card\CardHand", $cardHand);
    }

    /**
     * Test the returnCurrentMethod behaves as expected.
     */
    public function testReturnCurrentDeckMethod()
    {
        $cardHand = new CardHand(7);
        $testDeck = $cardHand->deckOfCards;
        $this->assertEquals($testDeck, $cardHand->returnCurrentDeck());
    }

    /**
     * Test that the getAsString method returns an array with the expected strings.
     */
    public function testReturnedStringArray()
    {
        $cardHand = new CardHand(7);
        $cards = [];
        foreach ($cardHand->cards as $card) {
            $cards[] = $card->getAsString();
        }
        $this->assertEquals($cardHand->getAsString(), $cards);
    }

    /**
     * Test that the getTotalNumericalValue method calculates the total value correctly.
     */
    public function testGetTotalNumericalValue()
    {
        $cardHand = new CardHand(7);
        $testTotalValue = 0;
        foreach($cardHand->cards as $card) {
            $testTotalValue += $card->numericValue;
        }

        $this->assertEquals($cardHand->getTotalNumericalValue(), $testTotalValue);
    }

    /**
     * Test that the getRandomCard method actually fetches a CardGraphic instance.
     */
    public function testGetRandomCard()
    {
        $cardHand = new CardHand(1);
        $cardHand->getRandomCard();
        $this->assertInstanceOf("\App\Card\CardGraphic", $cardHand->cards[1]);
    }

}
<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use App\Card\Card;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
    * Test to see if an instance of the Card class is created properly.
    */
    public function testCreateObject()
    {
        $card = new Card('♠', 7, 7);
        $this->assertInstanceOf("\App\Card\Card", $card);
    }

    /**
    * Test to see if the getAsString method returns a correct string.
    */
    public function testThatItReturnsCorrectString()
    {
        $card = new Card('♠', 7, 7);
        $cardAsString = $card->getAsString();
        $testString = '7♠';
        $this->assertEquals($cardAsString, $testString);
    }

}

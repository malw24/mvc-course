<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use App\Card\Card;


/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    public function testCreateObject()
    {
        $card = new Card('♠', 7, 7);
        $this->assertInstanceOf("\App\Card\Card", $card);
    }

    public function testThatItReturnsCorrectString() {
        $card = new Card('♠', 7, 7);
        $cardAsString = $card->getAsString();
        $testString = '7♠';
        $this->assertEquals($cardAsString, $testString);
    }

    public function checkValueAndNumericMatches()
    {
        $card = new Card('♠', 7, 7);
    }
    
}
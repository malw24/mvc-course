<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;
use App\Card\DeckOfCards;
use App\Card\CardHand;
use App\Card\CardGraphic;


/**
 * Test cases for class Card.
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Test that it is an instance of CardHand
     */
    public function testCreateObject()
    {
        $deckOfCards = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deckOfCards);
    }


    /**
     * Test that the deckOfCards loses one card via the getRandomCard method
     */
    public function testGetRandomCard()
    {
        $deckOfCards = new DeckOfCards();
        $oneCard = $deckOfCards->getRandomCard();
        $this->assertEquals($deckOfCards->getTheAmountOfCards(), 51);
    }

    /**
     * Test that the getWholeDeckAsArray method returns an array with the correct amount of cards
     */
    public function testGetWholeDeckArray()
    {
        $deckOfCards = new DeckOfCards();
        $deckOfCardsAsArray = $deckOfCards->getWholeDeckAsArray();
        $this->assertEquals("array", gettype($deckOfCardsAsArray));
        $totalAmountOfCards = 0;
        foreach($deckOfCardsAsArray as $card) {
            $totalAmountOfCards += 1;
        }
        $this->assertEquals(52, $totalAmountOfCards);
    }

    /**
     * Test that the getAsString method returns the correct string
     */
    public function testGetAsString()
    {
        $deckOfCards = new DeckOfCards();
        $deckOfCardsAsStringArray = $deckOfCards->getAsString();
        foreach($deckOfCardsAsStringArray as $card) {
            $this->assertEquals("string", gettype($card));
        }
        
    }

    /**
     * Test that the sortTheCurrentDeck method returns a sorted deck
     */
    public function testsortTheCurrentDeck()
    {
        $deckOfCards = new DeckOfCards();
    
        $deckSorted = $deckOfCards->getWholeDeckAsArray();
    
        $deckOfCards->shuffledTheDeck();
        $deckShuffled = $deckOfCards->getWholeDeckAsArray();

        $total = 0;
        for($index=0; $index<=51; $index++) {
            if($deckSorted[$index]->value !== $deckShuffled[$index]->value) {
                $total += 1;
            }
        }
      
        $this->assertFalse($total === 0);
       
        $deckSortedAfterShuffle = $deckOfCards->sortTheCurrentDeck();
        
        $total2 = 0;
        for($index=0; $index<=51; $index++) {
            if($deckSorted[$index]->value !== $deckSortedAfterShuffle[$index]->value) {
                $total2 += 1;
            }
        }
        $this->assertTrue($total2 === 0);
    }
    
}
<?php

namespace App\Card;

use App\Card\DeckOfCards;

/**
 * The CardHand class, acting as a player's hand of cards.
 */
class CardHand
{
    /**
     * @var array $cards                 The cards that the hand is currently holding.
     * @var DeckOfCards $deckOfCards     The deck of cards used to deal hands to the CardHand.
     */

    public array $cards = [];
    public DeckOfCards $deckOfCards;

    /**
     * Constructor to initiate the object.
     * @param int $amountOfCards    The amount of cards that hand starts with.
     *
     */
    public function __construct(int $amountOfCards)
    {
        $this->deckOfCards = new DeckOfCards();
        $this->deckOfCards->shuffledTheDeck();
        for ($counter = 0; $counter < $amountOfCards; $counter++) {
            $this->cards[] = $this->deckOfCards->getRandomCardAsObject();
        }

    }

    /**
     * Fetches the current deck and the cards currenlty in the deck.
     * @return object which is the used instance of the class DeckOfCards.
     */
    public function returnCurrentDeck(): object
    {
        return $this->deckOfCards;
    }

    /**
     * Fetches the current hand as a string.
     * @return array containing all the cards in the current hand as strings.
     */
    public function getAsString(): array
    {
        $cards = [];
        foreach ($this->cards as $card) {
            $cards[] = $card->getAsString();
        }
        return $cards;
    }

    /**
     * Fetches the total numerical value of the current hand.
     * @return int representing the total numerical value of the current player's hand.
     */
    public function getTotalNumericalValue(): int
    {
        $total = 0;
        foreach ($this->cards as $card) {
            $total += $card->numericValue;
        }
        return $total;
    }

    /**
     * Fetches a random card from the deck and puts it in the cards array.
     * @return array containing the newly fetched card.
     */
    public function getRandomCard(): array
    {
        $this->cards[] =  $this->deckOfCards->getRandomCardAsObject();
        return $this->cards;
    }

}

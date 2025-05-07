<?php

namespace App\Card;

use App\Card\CardGraphic;
use function App\Helpers\sortHelper;

/**
 * The DeckOfCards class, acting as the deck in the card game.
 */
class DeckOfCards
{
    /**
     * @var array $deck        The array that holds all of the GraphicCard instances.
     * @var array $suits       The array which holds all of the suits.
     */
    protected array $deck = [];

    private array $suits = [
        '♠',
        '♥',
        '♦',
        '♣',
    ];

    /**
     * Constructor to initiate the object.
     * The constructor creates the deck with all of the 52 cards sorted after suit and value.
     */
    public function __construct()
    {

        foreach ($this->suits as $suit) {

            for ($counter = 2; $counter <= 14; $counter++) {
                $value = $counter;

                if ($counter == 11) {
                    $value = 'J';
                }
                if ($counter == 12) {
                    $value = 'Q';
                }
                if ($counter == 13) {
                    $value = 'K';
                }
                if ($counter == 14) {
                    $value = 'A';
                }

                $this->deck[] = new CardGraphic($suit, $value, $counter);
            }
        }
    }


    /**
     * Sorts the current deck according to suit and value.
     * @return array with the sorted deck.
     */
    public function sortTheCurrentDeck(): array
    {
        $spadeValues = [];
        $heartValues = [];
        $diamondValues = [];
        $clubValues = [];
        $deckOfCardsAsArray = $this->deck;
        foreach ($deckOfCardsAsArray as $card) {
            if ($card->suit == '♠') {
                $spadeValues[] = $card->numericValue;
                sort($spadeValues);
            }
            if ($card->suit == '♥') {
                $heartValues[] = $card->numericValue;
                sort($heartValues);
            }
            if ($card->suit == '♦') {
                $diamondValues[] = $card->numericValue;
                sort($diamondValues);
            }
            if ($card->suit == '♣') {
                $clubValues[] = $card->numericValue;
                sort($clubValues);
            }
        }

        $sortedDeckArray = sortHelper($spadeValues, $heartValues, $diamondValues, $clubValues);


        return $sortedDeckArray;
    }

    /**
     * Fetches a random card from the deck as a string.
     * @return string as a random card from the deck.
     */
    public function getRandomCard(): string
    {
        // https://www.w3schools.com/php/func_array_rand.asp
        $randomIndex = array_rand($this->deck);
        $card = $this->deck[$randomIndex];
        unset($this->deck[$randomIndex]);
        return $card->getAsString();
    }

    /**
     * Fetches a random card from the deck as an instance of CardGraphic.
     * @return object as a random card from the deck.
     */
    public function getRandomCardAsObject(): object
    {
        // https://www.w3schools.com/php/func_array_rand.asp
        $randomIndex = array_rand($this->deck);
        $card = $this->deck[$randomIndex];
        unset($this->deck[$randomIndex]);
        return $card;
    }

    /**
     * Shuffles the current deck so that the order is of suits and values are random.
     * @return array of the whole deck as shuffled.
     */
    public function shuffledTheDeck(): array
    {
        // https://www.w3schools.com/Php/func_array_shuffle.asp
        shuffle($this->deck);
        return $this->deck;
    }

    /**
     * Fetches the whole deck as an array.
     * @return array containing the whole deck.
     */
    public function getWholeDeckAsArray(): array
    {
        $returnedArray = [];
        foreach ($this->deck as $card) {
            $returnedArray[] = $card;
        }
        return $returnedArray;
    }

    /**
     * Fetches each card as a string, puts it into an array and returns the array.
     * @return array containing every card of the current deck as a string.
     */
    public function getAsString(): array
    {
        $cards = [];
        foreach ($this->deck as $card) {
            $cards[] = $card->getAsString();
        }
        return $cards;
    }

    /**
     * Calculate and returns the total amount of cards left in the current deck.
     * @return int representing the total amount of cards in the deck currently.
     */
    public function getTheAmountOfCards(): int
    {
        $amountOfCardsLeft = count($this->deck);
        return $amountOfCardsLeft;
    }




}

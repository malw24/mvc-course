<?php

namespace App\Card;

/**
 * The Card class, acting as parent class to the CardGraphic class.
 */
class Card
{
    /**
     * @var string $suit            The cards suit.
     * @var string|int $value       The value of the card.
     * @var int $numericValue       The numeric value of the card.
     */
    public string $suit;
    public string|int $value;
    public int $numericValue;

    /**
     * Constructor to initiate the object.
     * The parameters are what define the cards suit, value and numeric value.
     *
     * @param string $suit          The current cards requested suit.
     * @param string|int $value     The current cards requested value.
     * @param int $numericValue      The current cards requested numeric value.
     *
     */
    public function __construct(string $suit, string|int $value, int $numericValue)
    {
        $this->suit =  $suit;
        $this->value = $value;
        $this->numericValue = $numericValue;
    }

    /**
     * Fetching the current cards value and suit as a string.
     * @return string containing the current card's value and suit as a string.
     */
    public function getAsString(): string
    {
        return "{$this->value}{$this->suit}";
    }

}

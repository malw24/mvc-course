<?php

namespace App\Card;

class Card
{
    public string $suit;
    public string|int $value;
    public int $numericValue;

    public function __construct(string $suit, string|int $value, int $numericValue)
    {
        $this->suit =  $suit;
        $this->value = $value;
        $this->numericValue = $numericValue;
    }

    public function getAsString(): string
    {
        return "{$this->value}{$this->suit}";
    }

}

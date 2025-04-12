<?php

namespace App\Card;

class Card
{
    protected $value;

    public function __construct($value, $suit)
    {
        $this->value = $value;
        $this->suit =  $suit;
    }

    // public function roll(): int
    // {
    //     $this->value = random_int(1, 13);
    //     return $this->value;
    // }

    // public function getValue(): int
    // {
    //     return $this->value;
    // }

    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
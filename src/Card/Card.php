<?php

namespace App\Card;

class Card
{
    public $suit;
    public $value;
    public $numeric_value;

    public function __construct($suit, $value, $numeric_value)
    {
        $this->suit =  $suit;
        $this->value = $value;
        $this->numeric_value = $numeric_value;
    }

    public function getAsString(): string
    {
        return "{$this->value}{$this->suit}";
    }

}

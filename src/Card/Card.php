<?php

namespace App\Card;


class Card
{
    protected $suit;
    protected $value;

    public function __construct($suit, $value)
    {
        $this->suit =  $suit;
        $this->value = $value;
    }

    public function getAsString(): string
    {
        return "{$this->value}{$this->suit}";
    }

}
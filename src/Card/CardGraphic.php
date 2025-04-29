<?php

namespace App\Card;

class CardGraphic extends Card
{
    public function __construct(string $suit, string|int $value, int $numericValue)
    {
        parent::__construct($suit, $value, $numericValue);
    }

}

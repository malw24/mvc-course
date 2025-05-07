<?php

namespace App\Card;

/**
 * The CardGraphic class, inheriting from the Card class.
 * CardGraphic is the actual class used in the game.
 */
class CardGraphic extends Card
{
    
    /**
     * Constructor to initiate the object. 
     * The parameters are what define the cards suit, value and numeric value.
     *
     * @param string $suit          The current cards requested suit.
     * @param string|int $value     The current cards requested value.
     * @param int $numericValue     The current cards requested numeric value.
     *                    
     */
    public function __construct(string $suit, string|int $value, int $numericValue)
    {
        parent::__construct($suit, $value, $numericValue);
    }

}

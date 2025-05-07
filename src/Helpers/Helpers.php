<?php

namespace App\Helpers;

use App\Card\CardGraphic;
/**
 * The Helpers class, containing helper methods.
 */
class Helpers
{

    /**
     * Constructor to initiate the object.
     * @param array $spadesValues    The values belonging to spades.
     * @param array $heartsValues    The values belonging to hearts.
     * @param array $diamondValues   The values belonging to diamonds.
     * @param array $clubValues    The values belonging to clubs.
     */
    public function sortHelper(array $spadesValues, array $heartsValues, array $diamondValues, array  $clubValues): array
    {
        $sortedDeckArray = [];

        $suitGroups = [];
        $suitGroups['♠'] = $spadesValues;
        $suitGroups['♥'] = $heartsValues;
        $suitGroups['♦'] = $diamondValues;
        $suitGroups['♣'] = $clubValues;
        //https://www.w3schools.com/php/php_arrays_associative.asp
        foreach ($suitGroups as $suit => $values) {
            $faceCard = "";
            foreach ($values as $value) {
                if ($value == 11) {
                    $faceCard = 'J';
                } if ($value == 12) {
                    $faceCard = 'Q';
                } if ($value == 13) {
                    $faceCard = 'K';
                } if ($value == 14) {
                    $faceCard = 'A';
                } if ($value < 11) {
                    $faceCard = $value;
                }



                $sortedDeckArray[] = new CardGraphic($suit, $faceCard, $value);
            }
        }


        return $sortedDeckArray;
    }
}

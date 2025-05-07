<?php

namespace App\Helpers;

use App\Card\CardGraphic;
/**
 * The Helpers class, containing helper methods.
 */
class Helpers
{

    /**
     * A helper method that helps sorts the current deck.
     * @param int[] $spadesValues                   The values belonging to spades.
     * @param int[] $heartsValues                   The values belonging to hearts.
     * @param int[] $diamondValues                  The values belonging to diamonds.
     * @param int[] $clubValues                     The values belonging to clubs.
     * @return CardGraphic[] $sortedDeckArray       The whole deck sorted.
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

<?php

namespace App\Helpers;

use App\Card\CardGraphic;

$sortedSuits = [];
function sortHelper(array $spadesValues, array $heartsValues, array $diamondValues, array  $clubValues) {
        $sortedDeckArray = [];

        $suitGroups = [];
        $suitGroups['♠'] = $spadesValues;
        $suitGroups['♥'] = $heartsValues;
        $suitGroups['♦'] = $diamondValues;
        $suitGroups['♣'] = $clubValues;
        //https://www.w3schools.com/php/php_arrays_associative.asp
        foreach ($suitGroups as $suit => $values) {
            foreach ($values as $value) {
                if ($value == 11) {
                    $faceCard = 'J';
                } if ($value == 12) {
                    $faceCard = 'Q';
                } if ($value == 13) {
                    $faceCard = 'K';
                } if ($value == 14) {
                    $faceCard = 'A';
                } else {
                    $faceCard = $value;
                }

                $sortedDeckArray[] = new CardGraphic($suit, $faceCard, $value);
            }
        }
  

    return $sortedDeckArray;
}


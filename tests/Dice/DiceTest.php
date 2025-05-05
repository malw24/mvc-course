<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;
use App\Dice\Dice;

/**
 * Test cases for class Dice.
 */
class DiceTest extends TestCase
{
    public function testCreateObject()
    {
        $die = new Dice();
        $this->assertInstanceOf("\App\Dice\Dice", $die);
    }

    /**
     * Roll the dice and assert value is within bounds.
     */
    public function testRollDice()
    {
        $die = new Dice();
        $res = $die->roll();
        $this->assertIsInt($res);

        $res = $die->getValue();
        $this->assertTrue($res >= 1);
        $this->assertTrue($res <= 6);
    }

    /**
     * Test that getAsString method works as intended.
     */
    public function testDiceStringArray()
    {
        $dice = new Dice();
        $dice->roll();
        $diceArray = [];
        $diceArray[] = $dice->getValue();
        $getValueAsString = "[" . $dice->getValue() . "]";
        $this->assertEquals($getValueAsString, $dice->getAsString());
    }

    public function testValueAttributeIsNull() 
    {
        $dice = new Dice();
        $res = $dice->getValue();
        $exp = null;
        $this->assertEquals($exp, $res);
    }

    //Denna behöver fixas
    // public function testThatValueChangesWhenRolled()
    // {
    //     $dice = new Dice();
    //     $res = $dice->roll();
    //     $res2 = $dice->roll();
    //     $this->assertFalse($res === $res2);
    // }
    
}


















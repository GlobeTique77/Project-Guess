<?php

namespace App\Tests\Core;

use App\Core\CardGame32;
use PHPUnit\Framework\TestCase;
use App\Core\Card;

class CardGame32Test extends TestCase
{
    public function testShuffle()
    {
        $cardGame = CardGame32::factoryCardGame32();
        $cardGame->shuffle();
        $cardGame2 = CardGame32::factoryCardGame32();
        $this->assertNotEquals($cardGame2, $cardGame);
    }

    public function testGetCard()
    {
        $cardGame = CardGame32::factoryCardGame32();
        $index = 1;
        $card1 = $cardGame->getCard($index);
        $this->assertEquals('Roi', $card1->getName());
        $this->assertEquals('Trèfle', $card1->getColor());
    }

    public function testGetCardIndexSup31()
    {
        $cardGame = CardGame32::factoryCardGame32();
        $index = 33;
        $card1 = $cardGame->getCard($index);
        $this->assertEquals('Roi', $card1->getName());
        $this->assertEquals('Trèfle', $card1->getColor());
    }

    public function testGetCardIndexInf0()
    {
        $cardGame = CardGame32::factoryCardGame32();
        $index = -682;
        $card1 = $cardGame->getCard($index);
        $this->assertEquals('8', $card1->getName());
        $this->assertEquals('Carreau', $card1->getColor());
    }

    public function testToString1Card()
    {
        $cardGame = new CardGame32([new Card('As', 'Trèfle')]);
        $this->assertEquals('CardGame32: 1 carte(s)', $cardGame->__toString());
    }

    public function testToString2Cards()
    {
        $cardGame = new CardGame32([new Card('As', 'Trèfle'), new Card('As', 'Coeur')]);
        $this->assertEquals('CardGame32: 2 carte(s)', $cardGame->__toString());
    }

    public function testFactoryCardGame32()
    {
        $cardGame = CardGame32::factoryCardGame32();
        $index = 1;
        $card1 = $cardGame->getCard($index);
        $this->assertEquals('Roi', $card1->getName());
        $this->assertEquals('Trèfle', $card1->getColor());
        $this->assertEquals('CardGame32: 32 carte(s)', $cardGame->__toString());

    }

    public function testCompareSameCard()
    {
        $cardGame = CardGame32::factoryCardGame32();
        $index = 0;
        $card1 = $cardGame->getCard($index); //As Trèfle
        $card2 = $cardGame->getCard($index); //As Trèfle
        $this->assertEquals(0, CardGame32::compare($card1,$card2));
    }

    public function testCompareSameNameNoSameColor()
    {
        $cardGame = CardGame32::factoryCardGame32();
        $index = 0;
        $index2 = 8;
        $card1 = $cardGame->getCard($index); //As Trèfle
        $card2 = $cardGame->getCard($index2); //As Pique
        $this->assertEquals(-1, CardGame32::compare($card1, $card2));
    }

    public function testCompareNoSameNameNoSameColor()
    {
        $cardGame = CardGame32::factoryCardGame32();
        $index = 1;
        $index2 = 11;
        $card1 = $cardGame->getCard($index); //Roi Trèfle
        $card2 = $cardGame->getCard($index2); //Valet Pique
        $this->assertEquals(1, CardGame32::compare($card1, $card2));
    }

    public function testCompareNoSameNameSameColor()
    {
        $cardGame = CardGame32::factoryCardGame32();
        $index = 7;
        $index2 = 6;
        $card1 = $cardGame->getCard($index); //7 Trèfle
        $card2 = $cardGame->getCard($index2); //8 Trèfle
        $this->assertEquals(-1, CardGame32::compare($card1, $card2));
    }

}
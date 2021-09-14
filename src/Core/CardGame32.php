<?php

namespace App\Core;

/**
 * Class CardGame32 : un jeu de cartes.
 * @package App\Core
 */
class CardGame32
{
  /**
   * @var $cards array a array of Cards
   */
  private $cards;

  /**
   * Guess constructor.
   * @param array $cards
   */
  public function __construct(array $cards)
  {
    $this->cards = $cards;
  }

  /**
   * Brasse le jeu de cartes
   */
  public function shuffle()
  {
    shuffle($this->cards);
  }

  /** définir une relation d'ordre entre instance de Card.
   * à valeur égale (name) c'est l'ordre de la couleur qui prime
   * coeur > carreau > pique > trèfle
   * Attention : si AS de Coeur est plus fort que AS de Trèfle,
   * 2 de Coeur sera cependant plus faible que 3 de Trèfle
   *
   *  Remarque : cette méthode n'est pas de portée d'instance (static)
   *
   * @see https://www.php.net/manual/fr/function.usort.php
   *
   * @param $c1 Card
   * @param $c2 Card
   * @return int
   * <ul>
   *  <li> zéro si $c1 et $c2 sont considérés comme égaux </li>
   *  <li> -1 si $c1 est considéré inférieur à $c2</li>
   * <li> +1 si $c1 est considéré supérieur à $c2</li>
   * </ul>
   *
   */
  public static function compare(Card $c1, Card $c2) : int
  {

    $c1NameStr = strtolower($c1->getName());
    $c2NameStr = strtolower($c2->getName());
    $c1ColorStr = strtolower($c1->getColor());
    $c2ColorStr = strtolower($c2->getColor());
    
    $ordersNames=['7'=>7, '8'=>8, '9'=>9, '10'=>10, 'valet'=>11, 'dame'=>12, 'roi'=>13, 'as'=>14];
    $ordersColors=['coeur'=>4, 'carreau'=>3, 'pique'=>2, 'trèfle'=>1];

    $c1Name=$ordersNames[$c1NameStr];
    $c2Name=$ordersNames[$c2NameStr];
    $c1Color=$ordersColors[$c1ColorStr];
    $c2Color=$ordersColors[$c2ColorStr];

    if ($c1Name === $c2Name && $c1Color === $c2Color) {
        return 0;
    }
    if ($c1Name === $c2Name) {
        return ($c1Color > $c2Color) ? +1 : -1;
    }
    return ($c1Name > $c2Name) ? +1 : -1;
  }

  /**
   * Crée un jeu de 32 cartes qui ont comme indice 0 à 31.
   * 
   * @return object
   */
  public static function factoryCardGame32() : CardGame32 {
    $cardGame = new CardGame32([new Card('As', 'Trèfle'), new Card('Roi', 'Trèfle'), new Card('Dame', 'Trèfle'), new Card('Valet', 'Trèfle'), new Card('10', 'Trèfle'), new Card('9', 'Trèfle'), new Card('8', 'Trèfle'), new Card('7', 'Trèfle'),
    new Card('As', 'Pique'), new Card('Roi', 'Pique'),  new Card('Dame', 'Pique'), new Card('Valet', 'Pique'), new Card('10', 'Pique'), new Card('9', 'Pique'), new Card('8', 'Pique'), new Card('7', 'Pique'),
    new Card('As', 'Carreau'), new Card('Roi', 'Carreau'), new Card('Dame', 'Carreau'), new Card('Valet', 'Carreau'), new Card('10', 'Carreau'), new Card('9', 'Carreau'), new Card('8', 'Carreau'), new Card('7', 'Carreau'),
    new Card('As', 'Coeur'), new Card('Roi', 'Coeur'), new Card('Dame', 'Coeur'), new Card('Valet', 'Coeur'), new Card('10', 'Coeur'), new Card('9', 'Coeur'), new Card('8', 'Coeur'), new Card('7', 'Coeur')]);

    return $cardGame;
  }

  /**
   * Permet de tirer une carte d'un jeu de carte avec un nombre donné par un utilisateur.
   * Si l'index est supérieur à 31 (le jeu va de 0 à 31) alors on récupère le reste de la division de 
   * l'index par 32 pour prendre le reste comme index, c'est comme si on repassait le jeu en boucle
   * jusqu'à qu'on arrive à la carte dans la vraie vie.
   * Si l'index est inférieur à 0, on fait une boucle en ajoutant 32 pour que l'index arrive entre
   * 0 et 31 pour qu'on est une carte, c'est comme si on repassait le jeu de cartes mais à l'envers.
   * 
   * @param $index
   * 
   * @return object
   */
  public function getCard($index) : Card {
    if ($index > 31){
      $index = $index % 32;
    }
    while($index < 0){
      $index = 32 + $index;
    }
    return  $this->cards[$index];
  }

  public function __toString(){
    return 'CardGame32: '.count($this->cards).' carte(s)';
  }

}
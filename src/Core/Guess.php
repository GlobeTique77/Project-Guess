<?php

namespace App\Core;

/**
 * Class Guess : la logique du jeu.
 * @package App\Core
 */
class Guess
{
  /**
   * @var CardGame32 un jeu de cartes
   */
  private $cardGame;

  /**
   * @var Card c'est la carte à deviner par le joueur
   */
  private $selectedCard;

  /**
   * @var bool pour prendre en compte lors d'une partie
   */
  private $withHelp;

  /**
   * Guess constructor.
   * @param CardGame32 $cardGame
   * @param Card $selectedCard
   * @param bool $withHelp
   */
  public function __construct(CardGame32 $cardGame, $selectedCard = null, bool $withHelp = true)
  {
    // TODO si $cardGame est null, affecter alors un jeu de 32 par défaut
    if ($cardGame == null){
      $cardGame = CardGame32::factoryCardGame32();
    }
    $this->cardGame = $cardGame;

    if ($selectedCard) {
      $this->selectedCard = $selectedCard;
    }  
    else {
      // TODO tirer aléatoirement une carte
      // $selectedCard = $cardGame->getCard(rand(0, 31));
      // $this->selectedCard = $selectedCard;
    }

    $this->withHelp = $withHelp;
  }

  public function getWithHelp()
  {
     return $this->withHelp;
  }

  /**
   * @param Card $card une soumission du joueur
   * @return bool true si la carte proposée est la bonne, false sinon
   */
  public function isMatch(Card $card)
  {
    return CardGame32::compare($card, $this->selectedCard) === 0;
  }

}


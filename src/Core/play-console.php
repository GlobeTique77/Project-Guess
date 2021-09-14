<?php

require '../../vendor/autoload.php';

echo "*** Création d'un jeu de 32 cartes.***\n";
$cardGame = App\Core\CardGame32::factoryCardGame32();

echo " ==== Instanciation du jeu, début de la partie. ==== \n";
$selectedCard = rand(0, 31);
$game =  new App\Core\Guess($cardGame, $cardGame->getCard($selectedCard), false);
$nbCard = 32;
$fin = false;
$help = readline("Voulez vous de l'aide ? 0 = oui, 1 = non : ");
$count = 0;
while($fin == false){
  $userCardIndex = readline("Entrez une position de carte dans le jeu (0 à 31): ");
  while ($userCardIndex < 0 || $userCardIndex > 31){
    $userCardIndex = readline("Mauvaise proposition. Entrez une position de carte dans le jeu (0 à 31): ");
  }

  $userCard = $cardGame->getCard($userCardIndex);
  $count++;

  if ($game->isMatch($userCard)) {
    echo 'Bravo ! Votre carte était : '.$cardGame->getCard($selectedCard)."\n";
    echo 'Nombre de proposition au total : '.$count."\n";
    $fin = true;
  } 
  else {
    echo "Loupé !\n";
    if ($help == 0){
      if ($userCardIndex > $selectedCard){
        echo "C'est moins ! \n";
      }
      if ($userCardIndex < $selectedCard){
        echo "C'est plus ! \n";
      }
    }
  }
}
if ($count == 1){
  echo "Vous avez beaucoup de chance ! \n";
}
if ($help == 0){
  if ($count > log($nbCard, 2)){
    echo $count." essais, vous n'avez pas choisi la bonne stratégie. \n";
  }
  else {
    echo $count." essais, vous avez choisi la bonne stratégie. \n";
  }
}
else {
  if ($count > $nbCard/2){
    echo "Vous n'avez pas de chance.";
  }
  elseif ($count > $nbCard/4) {
    echo "Vous avez un peu de chance.";
  }
  else {
    echo "Vous avez de la chance.";
  }
}

echo " ==== Fin prématurée de la partie ====\n";
echo "*** Terminé ***\n";
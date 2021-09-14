**BERTRAND Julien**
**SIO 22**

**Rapport Projet Guess**

**Objectif: apprendre les bases des tests unitaires avec un jeu qui crée un jeu de cartes, l'ordinateur en prend une et l'utilisateur doit deviner la carte.**

**[Lien gitlab du projet initial](https://gitlab.com/okpu/guesswhat)**

**[Lien github de mon projet](https://github.com/GlobeTique77/Project-Guess)**

**Challenge 1:**

Dans le terminal on vérifie que php et composer soient installés avec les commandes:
php --version et composer -V .
J'ai php 8.0.10 et composer 2.1.6.

Ensuite j'ai cloné le projet à partir du bouton clone de gitlab.

Avec composer install et composer update, j'ai installer les composants du fichier composer.json et je les ai mis à jour.
Puis j'ai installé phpunit avec ./bin/phpunit --version.
J'ai testé le projet avec la commande : php .\bin\phpunit ce qui me donne 4 erreur pour 8 tests

**Challenge 2:**

J'ai écrit les tests de CardTest.php, les tests "testCompare..." et testToString.
Pour les premiers je devais créer 2 objets Card avec leurs attributs name et colo.
Puis utiliser la méthode assertEquals() pour comparer le résultat attendu de compare() et directement l'utilisation de compare(les deux cartes) de la classe CardGame32.
Après avoir écrit ces tests, fallait écrire la méthode compare, on devait prendre en fonction le nom et la couleur de la carte.
Pour ça on devait créer 2 tableaux: un pour l'ordre des couleurs et un pour l'ordre des noms comme certains étaient en string et non en int, ce qui est donc incomparable.
Donc après avoir créer l'ordre des couleurs: coeur>carreau>pique>trèfle et l'ordre des noms: as>roi>...>8>7.
On devait récupérer avec getName et getColor les valeurs des cartes.
Après différents if que vous retrouvez dans la classe CardGame32, ça donnait 0 si les cartes étaient égales, 
1 si la première était plus grande et -1 si la prmère était plus petite.

Après un php .\bin\phpunit, il me reste 1 failure, le toString.
Pour ça j'ai dû allé dans la classe Card et créer la méthode.
Comme les cartes avaient 2 valeurs, je pouvais pas juste le return avec $this->name.$this->color.
J'ai du créer une variable : $completeCard = $this->name." ".$this->color;
Puis return la variable. Ca donnait par exemple "As Trèfle".
Donc voilà ce qu'il y a à l'intérieur du testToString:
    $card = new Card('As', 'Trèfle');
    $this->assertEquals('As Trèfle', $card->__toString());
    
**Challenge 3:**

J'ai créer une classe de tests: CardGame32Test.php .
Comme tests, il y a celui du shuffle, getCard, factoryCardGame32 et le toString.

En premier j'ai fais le shuffle, j'étais coincé comme je ne savais pas comment tester de l'aléatoire. 
Surtout si je devais mettre comme résultat attendu un certain ordre des cartes. 
Mais grâce au conseil de Mr Capuozzo: "inverse ta logique",
j'ai compris qu'il fallait juste que je test si le paquet mélangé était différent d'un paquet normal avec un assertNotEquals.
Après ce test, j'ai créer la méthode shuffle en regardant le manuel php sur la fonction shuffle qui mélange un tableau.

Pour le getCard, on devait vérifier si la clé donné par l'utilsateur correspondait bien à la clé d'une carte. 
Donc on crée un jeu de carte, on met un index puis on utilise getCard($index) pour le mettre dans $card1.
Après je fais deux tests avec assertEquals pour tester les valeurs de la carte en utilisant les méthodes getName et getColor (voir le code).
Mais l'utitilsateur pouvait mettre autre choses qu'une clé entre 0 et 31. 
S'il met un nombre supérieur à 31, je prend le nombre donné, je le divise par 32 et je récupère le reste.
C'est comme si après avoir passé le paquet, je le refait jusq'à tomber sur une carte.
Si c'est un nombre de négatif, je lui rajoute 32 jus'à arriver à un nombre entre à et 31, ça repasse le paquet mais à l'envers dans la vraie vie.
J'ai donc fait deux nouveaux tests pour tester les valeurs négatif et supérieur à 31.

Ensuite le test du toString, cette méthode doit renvoyer : CardGame32 : (nombre de cartes dans le jeu) carte(s).
Au début je crée un jeu de 2 cartes après je fais le assertEquals('CardGame32 : 2 carte(s)',$cardGame->__toString__());.
Ensuite dans CardGame32 cette méthode return juste la phrase mais le nombre s'obtient par un count($this->cards)

Ensuite le test de factoryCardGame32, j'ai combiné les tests getCard et toString,
le fait de tirer la bonne carte et qu'il y a bien 32 cartes.
Dans CardGame32, j'ai créeé chaque carte manuellement, c'était surtout pour pouvoir me repérer pour les tests après et j'ai oublié de l'automatiser.

**Challenge 4:**

Je n'ai pas trop compris comment je pouvais faire les tests de la classe Guess, et j'ai manqué de temps par mauvaise gestion du temps.
Donc j'ai surtout modifié le play-console.php.

J'ai commencé par randomiser la carte tirée avec un rand(0, 31).
Ensuite, j'ai fait une boucle while pour pouvoir continuer le jeu si on se trompe et le finir si on trouve.

J'ai créer l'aide en demandant à l'utilisateur avant de donner un nombre s'il la veut, si oui, à chaque proposition fausse il aura comme message: "C'est plus !"
ou "C'est moins !", si non, il aura juste le message: "Loupé !" jusq'à ce qu'il trouve.
Justement, quand l'utilisateur gagne, il a un message le félécitant en disant que la carte était: "name color" (remplacés par les vraies valeurs de la carte).

Et comme dernier ajout, l'analyse de la partie.
J'ai d'abord fait une variable qui compte le nombre de proposition donné par l'utilisateur.
S'il n'a pas pris l'aide, on analyse sa chance, s'il réussit en citant plus de la moitié des cartes, il n'a pas de chance,
si c'est entre 1/4 et 1/2 de cartes cités, il a un peu de chance, si c'est entre 2 et 1/4, il a de la chance.
Si c'est une proposition, il a beaucoup de chance.

Quand il a de l'aide, on analyse sa stratégie, s'il fait en un coup, on dit quand même qu'il a beaucoup de chance.
Si c'est entre 2 et log2(n) (donc pour un jeu de 32 cartes le log binaire de 32 donne 5), il a une bonne stratégie, si c'est plus c'est une mauvaise stratégie.

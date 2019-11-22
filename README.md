# Introduction

Pour lancer l’algorithme, il faut commencer par installer `php 7` et `composer`.

Executer `composer install` à la racine du projet pour installer les dépendences.

Ensuite, un simple `php test.php` pour lancer des matchs de test.

L’idée est d’instancier les équipes comme cela par exemple :
```php
$equipe1 = new Team("Team 1", 5); // 5 étant la position du classement.
$equipe2 = new Team("Team 2", 4);
$equipe3 = new Team("Team 3", 3);
$equipe4 = new Team("Team 4", 2);
```

Puis de définir contre qui chaque équipe peut jouer :
```php
$equipe1->addPossibleRival($equipe2)->addPossibleRival($equipe3)->addPossibleRival($equipe4);
$equipe2->addPossibleRival($equipe1)->addPossibleRival($equipe3)->addPossibleRival($equipe4);
$equipe3->addPossibleRival($equipe1)->addPossibleRival($equipe2)->addPossibleRival($equipe4);
$equipe4->addPossibleRival($equipe1)->addPossibleRival($equipe2)->addPossibleRival($equipe3);
```

Puis de passer à `get_matchs` le tableau des équipes :

`$results = get_matchs([$equipe1, $equipe2, $equipe3, $equipe4]);`

Il suffit de lire les résulats :

```php
foreach ($results as $result)
{
  echo $result[0]->getName() .' vs '.$result[1]->getName()."\n";
}
```

Ce qui nous donne :

```
Team 1 vs Team 2
Team 3 vs Team 4
```
 
# L’algorithme en lui-même.

En se basant sur l’exemple précendant :
1. `get_matchs` va trier le tableau en fonction du ranking (avec la fonction `cmpRank`)
2. `get_matchs_try` va _essayer_ d’associer la première équipe avec celle qui est la plus proche dans le classement et dont le match n’est pas déjà assigné (c’est l’intérêt de la méthode `$team->isLock()`).
Il l’obtient grâce à la méthode `$team->getNearRival()`. Dans le sénario parfait, `$team` joue toujours contre `$team->getNearRival()`

# Et si le sénario n’est pas parfait ?
Si `$team->getNearRival()` ne trouve aucun adversaire (typiquement, car ils sont tous déjà assigné à d’autres adversaires) :

On a eu deux idées :
- Soit on permute le tableau trié jusqu’à trouver une solution
-> Le soucis de cette solution, c’est que de permuter 21 équipes, ça a une complexité de `21 factorielle` et c’est impossible.
- Soit on mélange le tableau au hasard
-> Le soucis c’est qu’on ne prend plus du tout en compte le classement

# Et si le sénario est impossible
Il y a des cas tout bonnement impossible à résoudre. Pour l’intant le comportement n’est pas défini.

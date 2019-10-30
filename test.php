<?php

require ('vendor/autoload.php');

include ('Team.php');
include ('get_matchs.php');

echo 'Test automatique…'."\n";


$j = 0;
while($j++ < 100000) {
    echo "Tour numéro $j\n";
    for ($nbrTeam = 8; $nbrTeam <= 8; $nbrTeam += 2) {
        $ranking = range(1, $nbrTeam);
        shuffle($ranking);

        // On génère plein de teams
        echo 'Debut d\'un championnat avec ' . $nbrTeam . ' équipes #'.$j.' . '."\n";
        $teams = [];
        for ($i = 0; $i < $nbrTeam; $i++) {
            $teams[] = new Team("Team " . $i, $ranking[$i]);
        }
        // Pour chaque équipe, on va lui ajouter comme PossibleRival toutes les autres équipes
        foreach ($teams as $team) {
            foreach ($teams as $team2) {
                if ($team2 !== $team) {
                    $team->addPossibleRival($team2);
                }
            }
        }

        // On récupère les matchs et on les supprime histoire de faire comme un "historique"
        for ($i = 0; $i < 5; $i++) {

            echo 'Tour n° ' . $i . "\n";


            // À chaque tour on modifie le ranking
            shuffle($ranking);
            foreach ($teams as $key => $team) {
                $team->setRank($ranking[$key]);
            }

            $matchs = get_matchs($teams);

            foreach ($matchs as $match) {
                echo $match[0]->getName() . ' (Rank : ' . $match[0]->getRank() . ') vs ' . $match[1]->getName() . " (Rank : " . $match[1]->getRank() . ")\n";
                $match[0]->removePossibleRival($match[1]);
                $match[1]->removePossibleRival($match[0]);
            }
        }
    }
}


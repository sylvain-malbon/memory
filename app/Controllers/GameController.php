<?php
namespace App\Controllers;

use App\Models\GameModel;
use App\Models\CardModel;

class GameController
{
    public function start(string $playerName, int $pairs)
    {
        $gameModel = new GameModel();
        $cardModel = new CardModel();

        // Crée une nouvelle partie en BDD
        $gameId = $gameModel->create($playerName, $pairs);

        // Tire les cartes aléatoirement
        $cards = $cardModel->all();
        shuffle($cards);
        $selected = array_slice($cards, 0, $pairs * 2);

        // Passe les données à la vue
        $moves = 0;
        $score = 0;

        require 'views/game.php';
    }

    public function play(int $gameId, int $cardId1, int $cardId2)
    {
        $gameModel = new GameModel();
        $game = $gameModel->find($gameId);

        // Incrémente le compteur de coups
        $gameModel->updateMoves($gameId, $game->getMoves() + 1);

        // Logique de comparaison des cartes (simplifiée)
        // Ici tu pourrais utiliser Card::match() etc.

        require 'views/game.php';
    }
}

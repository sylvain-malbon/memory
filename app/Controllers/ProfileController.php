<?php
namespace App\Controllers;

use App\Models\GameModel;

class ProfileController
{
    public function show(string $playerName)
    {
        $gameModel = new GameModel();

        $stmt = \Core\Database::getPdo()->prepare(
            'SELECT id, pairs, moves, score, created_at 
             FROM games 
             WHERE player_name = :player_name 
             ORDER BY created_at DESC'
        );
        $stmt->execute(['player_name' => $playerName]);
        $games = $stmt->fetchAll();

        require 'views/profile.php';
    }
}

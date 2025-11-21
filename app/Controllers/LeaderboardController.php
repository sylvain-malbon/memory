<?php
namespace App\Controllers;

use App\Models\GameModel;

class LeaderboardController
{
    public function index()
    {
        $gameModel = new GameModel();

        // Classement des 10 meilleurs scores
        $stmt = \Core\Database::getPdo()->query(
            'SELECT player_name, score, created_at 
             FROM games 
             ORDER BY score ASC, moves ASC 
             LIMIT 10'
        );
        $leaderboard = $stmt->fetchAll();

        require 'views/leaderboard.php';
    }
}

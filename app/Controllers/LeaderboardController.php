<?php
namespace App\Controllers;

use Core\BaseController;
use App\Models\GameModel;

class LeaderboardController extends BaseController
{
    public function index()
    {
        // Classement des 10 meilleurs scores
        $stmt = \Core\Database::getPdo()->query(
            'SELECT player_name, score, created_at 
             FROM games 
             ORDER BY score ASC, moves ASC 
             LIMIT 10'
        );
        $leaderboard = $stmt->fetchAll();

        $this->render('leaderboard/index', [
            'title' => 'Hall of Fame',
            'leaderboard' => $leaderboard
        ]);
    }
}

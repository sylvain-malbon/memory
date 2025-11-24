<?php
namespace App\Controllers;

use Core\BaseController;
use App\Models\GameModel;

class LeaderboardController extends BaseController
{
    public function index()
    {
        $gameModel = new GameModel();
        $leaderboard = $gameModel->getTopScores(10);

        $this->render('leaderboard/index', [
            'title' => 'Hall of Fame',
            'leaderboard' => $leaderboard
        ]);
    }
}

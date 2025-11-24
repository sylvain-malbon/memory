<?php
namespace App\Controllers;

use Core\BaseController;
use App\Models\GameModel;

class ProfileController extends BaseController
{
    public function show()
    {
        // Validation du nom de joueur
        $playerName = $_GET['player'] ?? $_SESSION['playerName'] ?? 'Joueur';
        $playerName = trim($playerName);
        
        if (!preg_match('/^[a-zA-Z0-9\s\-_]{1,50}$/u', $playerName)) {
            $playerName = 'Joueur';
        }

        $gameModel = new GameModel();
        $games = $gameModel->getPlayerGames($playerName);

        $this->render('home/profil/index', [
            'title' => 'Profil de ' . htmlspecialchars($playerName, ENT_QUOTES, 'UTF-8'),
            'playerName' => htmlspecialchars($playerName, ENT_QUOTES, 'UTF-8'),
            'games' => $games
        ]);
    }
}

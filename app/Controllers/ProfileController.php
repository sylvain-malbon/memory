<?php
namespace App\Controllers;

use Core\BaseController;
use App\Models\GameModel;

class ProfileController extends BaseController
{
    public function show()
    {
        // Récupérer le nom du joueur depuis les paramètres
        $playerName = $_GET['player'] ?? 'Joueur';

        $stmt = \Core\Database::getPdo()->prepare(
            'SELECT id, pairs, moves, score, created_at 
             FROM games 
             WHERE player_name = :player_name 
             ORDER BY created_at DESC'
        );
        $stmt->execute(['player_name' => $playerName]);
        $games = $stmt->fetchAll();

        $this->render('home/profil/index', [
            'title' => 'Profil de ' . htmlspecialchars($playerName),
            'playerName' => $playerName,
            'games' => $games
        ]);
    }
}

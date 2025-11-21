<?php
namespace App\Controllers;

use Core\BaseController;
use App\Models\GameModel;
use App\Models\CardModel;

class GameController extends BaseController
{
    public function start()
    {
        // Afficher le formulaire de démarrage ou rediriger vers la vue du jeu
        $this->render('game/index', [
            'title' => 'Nouvelle partie'
        ]);
    }

    public function play()
    {
        // Récupérer les paramètres depuis $_POST ou $_GET
        $playerName = $_POST['playerName'] ?? $_GET['playerName'] ?? 'Joueur';
        $pairs = (int) ($_POST['pairs'] ?? $_GET['pairs'] ?? 6);

        $gameModel = new GameModel();
        $cardModel = new CardModel();

        // Crée une nouvelle partie en BDD
        $gameId = $gameModel->create($playerName, $pairs);

        // Stocker en session
        $_SESSION['gameId'] = $gameId;
        $_SESSION['playerName'] = $playerName;
        $_SESSION['pairs'] = $pairs;
        $_SESSION['moves'] = 0;

        // Tire les cartes aléatoirement
        $allCards = $cardModel->all();
        shuffle($allCards);
        
        // Sélectionner le nombre de cartes uniques nécessaires
        $selectedCards = array_slice($allCards, 0, $pairs);
        
        // DUPLIQUER chaque carte pour créer des paires
        $cards = [];
        foreach ($selectedCards as $card) {
            $cards[] = $card; // Première carte
            $cards[] = clone $card; // Deuxième carte (copie)
        }
        
        // Mélanger toutes les cartes (paires mélangées)
        shuffle($cards);

        // Passe les données à la vue
        $this->render('game/index', [
            'title' => 'Memory Game',
            'cards' => $cards,
            'moves' => 0,
            'score' => 0,
            'gameId' => $gameId,
            'playerName' => $playerName
        ]);
    }

    public function updateMoves()
    {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['gameId'])) {
            echo json_encode(['success' => false, 'error' => 'No active game']);
            return;
        }
        
        $_SESSION['moves']++;
        
        $gameModel = new GameModel();
        $gameModel->updateMoves($_SESSION['gameId'], $_SESSION['moves']);
        
        $game = $gameModel->find($_SESSION['gameId']);
        
        // Retourner aussi le nom du joueur pour vérification
        echo json_encode([
            'success' => true,
            'moves' => $_SESSION['moves'],
            'score' => $game ? $game->getScore() : 0,
            'playerName' => $_SESSION['playerName'] ?? 'Joueur',
            'gameId' => $_SESSION['gameId']
        ]);
    }

    public function update()
    {
        // Récupérer les paramètres
        $gameId = (int) ($_POST['gameId'] ?? $_GET['gameId'] ?? 0);
        $cardId1 = (int) ($_POST['cardId1'] ?? $_GET['cardId1'] ?? 0);
        $cardId2 = (int) ($_POST['cardId2'] ?? $_GET['cardId2'] ?? 0);

        if ($gameId === 0) {
            http_response_code(400);
            echo "Partie invalide";
            return;
        }

        $gameModel = new GameModel();
        $game = $gameModel->find($gameId);

        if (!$game) {
            http_response_code(404);
            echo "Partie non trouvée";
            return;
        }

        // Incrémente le compteur de coups
        $gameModel->updateMoves($gameId, $game->getMoves() + 1);

        // Logique de comparaison des cartes (simplifiée)
        // Ici tu pourrais utiliser Card::match() etc.

        // Récupérer les cartes pour réafficher
        $cardModel = new CardModel();
        $cards = $cardModel->all();

        $this->render('game/index', [
            'title' => 'Memory Game',
            'cards' => $cards,
            'moves' => $game->getMoves() + 1,
            'score' => $game->getScore(),
            'gameId' => $gameId,
            'playerName' => $game->getPlayerName()
        ]);
    }
}

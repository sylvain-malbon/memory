<?php
namespace App\Controllers;

use Core\BaseController;
use App\Models\GameModel;
use App\Models\CardModel;
use App\Models\Card;

class GameController extends BaseController
{
    public function start()
    {
        // Si une partie est en cours, afficher le jeu
        if (isset($_SESSION['gameId'])) {
            $gameModel = new GameModel();
            $game = $gameModel->find($_SESSION['gameId']);
            
            if ($game) {
                $cardModel = new CardModel();
                $allCards = $cardModel->all(); // Retourne des objets Card
                
                if (count($allCards) < $game['pairs']) {
                    $_SESSION['error'] = 'Pas assez de cartes disponibles';
                    unset($_SESSION['gameId']);
                    header('Location: ' . url('/game'));
                    exit;
                }
                
                shuffle($allCards);
                $selectedCards = array_slice($allCards, 0, $game['pairs']);
                
                $cards = [];
                foreach ($selectedCards as $card) {
                    $cards[] = $card;
                    // Cloner l'objet Card pour la paire
                    $cards[] = clone $card;
                }
                shuffle($cards);
                
                $this->render('game/index', [
                    'title' => 'Memory Game',
                    'cards' => $cards, // Objets Card
                    'moves' => $game['moves'],
                    'score' => $game['score'] ?? 0,
                    'gameId' => $game['id'],
                    'playerName' => $_SESSION['playerName'] ?? 'Joueur',
                    'gameStarted' => true
                ]);
                return;
            }
        }
        
        // Sinon, afficher le formulaire de démarrage
        $this->render('game/index', [
            'title' => 'Nouvelle partie',
            'gameStarted' => false
        ]);
    }

    public function play()
    {
        // Vérifier que c'est une requête POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Méthode non autorisée';
            header('Location: ' . url('/game'));
            exit;
        }
        
        // Détruire l'ancienne session de jeu avant de créer une nouvelle partie
        unset($_SESSION['gameId']);
        unset($_SESSION['playerName']);
        
        // Validation du nom de joueur
        $playerName = trim($_POST['playerName'] ?? '');
        
        if (empty($playerName)) {
            $_SESSION['error'] = 'Le nom de joueur est obligatoire';
            header('Location: ' . url('/game'));
            exit;
        }
        
        if (!preg_match('/^[a-zA-Z0-9\s\-_]{1,50}$/u', $playerName)) {
            $_SESSION['error'] = 'Nom invalide (lettres, chiffres, espaces, tirets uniquement)';
            header('Location: ' . url('/game'));
            exit;
        }
        
        // Validation du nombre de paires
        $pairs = filter_input(INPUT_POST, 'pairs', FILTER_VALIDATE_INT);
        
        if ($pairs === false || $pairs === null || $pairs < 3 || $pairs > 12) {
            $_SESSION['error'] = 'Nombre de paires invalide (entre 3 et 12)';
            header('Location: ' . url('/game'));
            exit;
        }
        
        try {
            $gameModel = new GameModel();
            
            // Crée une nouvelle partie en BDD
            $gameId = $gameModel->create($playerName, $pairs);
            
            // Stocker en session
            $_SESSION['gameId'] = $gameId;
            $_SESSION['playerName'] = htmlspecialchars($playerName, ENT_QUOTES, 'UTF-8');
            
            // Rediriger vers le jeu
            header('Location: ' . url('/game'));
            exit;
            
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la création de la partie';
            error_log("Erreur GameController::play() : " . $e->getMessage());
            header('Location: ' . url('/game'));
            exit;
        }
    }

    public function updateMoves()
    {
        header('Content-Type: application/json');
        
        // Vérifier que c'est une requête AJAX
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || 
            $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
            http_response_code(403);
            echo json_encode(['success' => false, 'error' => 'Requête non autorisée']);
            exit;
        }
        
        // Vérifier la session
        if (!isset($_SESSION['gameId'])) {
            echo json_encode(['success' => false, 'error' => 'Aucune partie en cours']);
            exit;
        }
        
        try {
            // Récupérer le jeu actuel
            $gameModel = new GameModel();
            $game = $gameModel->find($_SESSION['gameId']);
            
            if (!$game) {
                echo json_encode(['success' => false, 'error' => 'Partie introuvable']);
                exit;
            }
            
            // Incrémenter les coups
            $newMoves = ($game['moves'] ?? 0) + 1;
            $gameModel->updateMoves($_SESSION['gameId'], $newMoves);
            
            echo json_encode([
                'success' => true,
                'moves' => $newMoves,
                'playerName' => $_SESSION['playerName'] ?? 'Joueur',
                'gameId' => $_SESSION['gameId']
            ]);
            
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Erreur serveur']);
            error_log("Erreur updateMoves : " . $e->getMessage());
        }
        exit;
    }

    public function reset()
    {
        // Détruire la partie en cours
        unset($_SESSION['gameId']);
        unset($_SESSION['playerName']);
        
        // Rediriger vers le formulaire de nouvelle partie
        header('Location: ' . url('/game'));
        exit;
    }
}

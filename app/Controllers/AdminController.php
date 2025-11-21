<?php
namespace App\Controllers;

use Core\BaseController;

class AdminController extends BaseController
{
    /**
     * Page d'administration
     */
    public function index()
    {
        $this->render('admin/index', [
            'title' => 'Administration'
        ]);
    }

    /**
     * Reset du Hall of Fame
     */
    public function resetLeaderboard()
    {
        // Sécurité basique (à améliorer avec un mot de passe)
        if (!isset($_POST['confirm']) || $_POST['confirm'] !== 'RESET') {
            http_response_code(403);
            echo "Confirmation requise";
            return;
        }

        try {
            $pdo = \Core\Database::getPdo();
            
            // Désactiver temporairement les contraintes de clés étrangères
            $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
            
            // Vérifier si la table game_cards existe
            $tableExists = $pdo->query("SHOW TABLES LIKE 'game_cards'")->rowCount() > 0;
            
            if ($tableExists) {
                // Vider la table game_cards si elle existe
                $pdo->exec('TRUNCATE TABLE game_cards');
            }
            
            // Vider la table games
            $pdo->exec('TRUNCATE TABLE games');
            
            // Réactiver les contraintes
            $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
            
            // Rediriger vers le leaderboard
            header('Location: /leaderboard');
            exit;
            
        } catch (\Exception $e) {
            // S'assurer de réactiver les contraintes même en cas d'erreur
            try {
                $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
            } catch (\Exception $e2) {
                // Ignorer l'erreur de réactivation
            }
            
            http_response_code(500);
            echo "Erreur lors du reset : " . $e->getMessage();
        }
    }

    /**
     * Supprimer les parties anciennes
     */
    public function cleanOldGames()
    {
        if (!isset($_POST['days'])) {
            http_response_code(400);
            echo "Nombre de jours requis";
            return;
        }

        $days = (int) $_POST['days'];

        try {
            $pdo = \Core\Database::getPdo();
            $stmt = $pdo->prepare('DELETE FROM games WHERE created_at < DATE_SUB(NOW(), INTERVAL :days DAY)');
            $stmt->execute(['days' => $days]);
            
            $deleted = $stmt->rowCount();
            
            header('Location: /admin?deleted=' . $deleted);
            exit;
            
        } catch (\Exception $e) {
            http_response_code(500);
            echo "Erreur : " . $e->getMessage();
        }
    }
}

<?php
namespace App\Models;

use Core\Database;

class GameModel
{
    public function getTopScores(int $limit = 10): array
    {
        $stmt = Database::getPdo()->prepare(
            'SELECT player_name, moves, score, created_at 
             FROM games 
             WHERE moves > 0
             ORDER BY moves ASC, created_at ASC 
             LIMIT :limit'
        );
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPlayerGames(string $playerName): array
    {
        $stmt = Database::getPdo()->prepare(
            'SELECT id, pairs, moves, score, created_at 
             FROM games 
             WHERE player_name = :player_name 
             ORDER BY created_at DESC'
        );
        $stmt->execute(['player_name' => $playerName]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function all(): array
    {
        $stmt = Database::getPdo()->query(
            'SELECT id, player_name, pairs, moves, score, created_at FROM games ORDER BY created_at DESC'
        );
        return $stmt->fetchAll(\PDO::FETCH_ASSOC); // ← Retourne directement un tableau
    }

    public function find(int $id): ?array // ← Changé de ?Game à ?array
    {
        $stmt = Database::getPdo()->prepare(
            'SELECT id, player_name, pairs, moves, score, created_at FROM games WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    public function create(string $playerName, int $pairs): int
    {
        $stmt = Database::getPdo()->prepare(
            'INSERT INTO games (player_name, pairs, moves, created_at) VALUES (:player_name, :pairs, 0, NOW())'
        );

        $stmt->execute([
            'player_name' => $playerName,
            'pairs' => $pairs
        ]);

        return (int) Database::getPdo()->lastInsertId();
    }

    public function updateMoves(int $id, int $moves): void
    {
        $stmt = Database::getPdo()->prepare(
            'UPDATE games SET moves = :moves WHERE id = :id'
        );

        $stmt->execute([
            'moves' => $moves,
            'id' => $id
        ]);
    }
}

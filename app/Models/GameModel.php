<?php
namespace App\Models;

use Core\Database;
use App\Classes\Game;

class GameModel
{
    public function all(): array
    {
        $stmt = Database::getPdo()->query(
            'SELECT id, player_name, pairs, moves, score, created_at FROM games ORDER BY created_at DESC'
        );

        $rows = $stmt->fetchAll();
        $games = [];

        foreach ($rows as $row) {
            $games[] = new Game(
                $row['id'],
                $row['player_name'],
                $row['pairs'],
                $row['moves'],
                $row['score'],
                $row['created_at']
            );
        }

        return $games;
    }

    public function find(int $id): ?Game
    {
        $stmt = Database::getPdo()->prepare(
            'SELECT id, player_name, pairs, moves, score, created_at FROM games WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if ($row) {
            return new Game(
                $row['id'],
                $row['player_name'],
                $row['pairs'],
                $row['moves'],
                $row['score'],
                $row['created_at']
            );
        }

        return null;
    }

    public function create(string $playerName, int $pairs): int
    {
        $stmt = Database::getPdo()->prepare(
            'INSERT INTO games (player_name, pairs, moves) VALUES (:player_name, :pairs, 0)'
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

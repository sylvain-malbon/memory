<?php
namespace App\Models;

use Core\Database;
use App\Classes\Card;

class CardModel
{
    public function all(): array
    {
        $stmt = Database::getPdo()->query(
            'SELECT id, title, body FROM cards ORDER BY id DESC'
        );

        $rows = $stmt->fetchAll();

        $cards = [];
        foreach ($rows as $row) {
            $cards[] = new Card(
                $row['id'],
                $row['name'],
                $row['image']
            );
        }

        return $cards;
    }

    public function find(int $id): ?Card
    {
        $stmt = Database::getPdo()->prepare(
            'SELECT id, name, image FROM cards WHERE id = :id'
        );

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if ($row) {
            return new Card(
                $row['id'],
                $row['name'],
                $row['image']
            );
        }

        return null;
    }
}

<?php
namespace App\Models;

use Core\Database;
use App\Classes\Card; // <-- Ajoute cette ligne pour utiliser la bonne classe

class CardModel
{
    public function all(): array
    {
        $stmt = Database::getPdo()->query(
            'SELECT id, name, image FROM cards'
        );
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Transformer les tableaux en objets Card
        return array_map(fn($row) => new Card(
            $row['id'],
            $row['name'],
            $row['image']
        ), $data);
    }

    public function find(int $id): ?Card
    {
        $stmt = Database::getPdo()->prepare(
            'SELECT id, name, image FROM cards WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return $data ? new Card(
            $data['id'],
            $data['name'],
            $data['image']
        ) : null;
    }
}

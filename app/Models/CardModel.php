<?php
namespace App\Models;

use Core\Database;

class CardModel
{
    public function all(): array
    {
        $stmt = Database::getPdo()->query(
            'SELECT * FROM cards ORDER BY id DESC'
        );

        return $stmt->fetchAll();
    }

}
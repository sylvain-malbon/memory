CREATE DATABASE IF NOT EXISTS memory
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_unicode_ci;

USE memory;

-- Table cards
CREATE TABLE IF NOT EXISTS cards (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  image VARCHAR(255) NOT NULL,
  UNIQUE KEY uk_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table games
CREATE TABLE IF NOT EXISTS games (
  id INT AUTO_INCREMENT PRIMARY KEY,
  player_name VARCHAR(50) NOT NULL CHECK (player_name <> ''),
  pairs INT NOT NULL CHECK (pairs > 0),
  moves INT NOT NULL DEFAULT 0 CHECK (moves >= 0),
  score FLOAT GENERATED ALWAYS AS (moves / pairs) STORED,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_player_name (player_name),
  INDEX idx_created_at (created_at),
  INDEX idx_score (score)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table intermédiaire pour relier les parties aux cartes
CREATE TABLE IF NOT EXISTS game_cards (
  game_id INT NOT NULL,
  card_id INT NOT NULL,
  PRIMARY KEY (game_id, card_id),
  FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE,
  FOREIGN KEY (card_id) REFERENCES cards(id) ON DELETE CASCADE,
  INDEX idx_game_id (game_id),
  INDEX idx_card_id (card_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Vue pour afficher le classement des 10 meilleurs joueurs
CREATE OR REPLACE VIEW leaderboard AS
SELECT player_name, score, created_at
FROM games
ORDER BY score ASC, created_at ASC
LIMIT 10;

-- Ajout des cartes (INSERT IGNORE évite les doublons si réexécuté)
-- Note: L'image Coquillage.png est utilisée pour le dos des cartes
INSERT IGNORE INTO cards (name, image) VALUES
('Abeille', 'Abeille.png'),
('Carpe', 'Carpe.png'),
('Chien Verrin', 'ChienVerrin.png'),
('Coq', 'Coq.png'),
('Corbeau', 'Corbeau.png'),
('Dragon', 'Dragon.png'),
('Faisan', 'Faisan.png'),
('Goéland', 'Goéland.png'),
('Grenouille', 'Grenouille.png'),
('Grue', 'Grue.png'),
('Lapin', 'Lapin.png'),
('Lucioles', 'Lucioles.png'),
('Oiseau', 'Oiseau.png'),
('Paon', 'Paon.png'),
('Pic', 'Pic.png'),
('Poulpe', 'Poulpe.png'),
('Renard', 'Renard.png'),
('Sanglier', 'Sanglier.png'),
('Serpent', 'Serpent.png'),
('Shika', 'Shika.png'),
('Souris', 'Souris.png'),
('Tigre', 'Tigre.png'),
('Tortue', 'Tortue.png');

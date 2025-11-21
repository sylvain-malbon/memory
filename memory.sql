CREATE DATABASE IF NOT EXISTS memory
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_unicode_ci;

USE memory;

-- Table cards
CREATE TABLE cards (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,       -- nom ou identifiant de la carte
  image VARCHAR(255) NOT NULL,     -- chemin vers l’image
  UNIQUE (name)                    -- chaque carte doit avoir un nom unique
);

-- Table games
CREATE TABLE games (
  id INT AUTO_INCREMENT PRIMARY KEY,
  player_name VARCHAR(50) NOT NULL, -- nom du joueur (pas de table users)
  pairs INT NOT NULL CHECK (pairs > 0),   -- nombre de paires (au moins 1)
  moves INT NOT NULL CHECK (moves >= 0),  -- nombre de coups (pas négatif)
  score FLOAT GENERATED ALWAYS AS (moves / pairs) STORED, -- calcul automatique
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_player_name (player_name),    -- index pour recherche rapide par joueur
  INDEX idx_created_at (created_at)       -- index pour trier par date
);

-- Ajout d'un oubli à Table games
ALTER TABLE games
ADD CONSTRAINT chk_player_name CHECK (player_name <> '');

-- Table intermédiaire pour relier les parties aux cartes
CREATE TABLE game_cards (
  game_id INT NOT NULL,
  card_id INT NOT NULL,
  PRIMARY KEY (game_id, card_id),
  FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE,
  FOREIGN KEY (card_id) REFERENCES cards(id) ON DELETE CASCADE,
  INDEX idx_game_id(game_id),
  INDEX idx_card_id(card_id)
);

-- Vue pour afficher le classement des joueurs
CREATE VIEW leaderboard AS
SELECT player_name, score, created_at
FROM games
ORDER BY score ASC
LIMIT 10;

-- Ajout des cartes
INSERT INTO cards (name, image) VALUES
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
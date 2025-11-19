-- Script SQL de base pour le projet Memory

CREATE DATABASE IF NOT EXISTS Memory CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE Memory;

-- Table cards
id INT AUTO_INCREMENT PRIMARY KEY
name VARCHAR(50)       -- nom ou identifiant de la carte
image VARCHAR(255)     -- chemin vers l’image

-- Table games
id INT AUTO_INCREMENT PRIMARY KEY
player_name VARCHAR(50), -- nom du joueur (pas de table users)
pairs INT              -- nombre de paires dans la partie
moves INT              -- nombre de coups joués
score FLOAT            -- calculé : moves / pairs
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
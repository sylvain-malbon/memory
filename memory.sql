-- Clean SQL Dump for database `memory`
-- Compatible with MySQL/MariaDB sur Plesk

-- --------------------------------------------------------
-- Table structure for table `cards`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `cards`;
CREATE TABLE `cards` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cards` (`id`, `name`, `image`) VALUES
(1, 'Abeille', 'Abeille.png'),
(2, 'Carpe', 'Carpe.png'),
(3, 'Chien Verrin', 'ChienVerrin.png'),
(4, 'Coq', 'Coq.png'),
(5, 'Corbeau', 'Corbeau.png'),
(6, 'Dragon', 'Dragon.png'),
(7, 'Faisan', 'Faisan.png'),
(8, 'Goéland', 'Goéland.png'),
(9, 'Grenouille', 'Grenouille.png'),
(10, 'Grue', 'Grue.png'),
(11, 'Lapin', 'Lapin.png'),
(12, 'Lucioles', 'Lucioles.png'),
(13, 'Oiseau', 'Oiseau.png'),
(14, 'Paon', 'Paon.png'),
(15, 'Pic', 'Pic.png'),
(16, 'Poulpe', 'Poulpe.png'),
(17, 'Renard', 'Renard.png'),
(18, 'Sanglier', 'Sanglier.png'),
(19, 'Serpent', 'Serpent.png'),
(20, 'Shika', 'Shika.png'),
(21, 'Souris', 'Souris.png'),
(22, 'Tigre', 'Tigre.png'),
(23, 'Tortue', 'Tortue.png');

-- --------------------------------------------------------
-- Table structure for table `games`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `games`;
CREATE TABLE `games` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `player_name` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pairs` INT UNSIGNED NOT NULL,
  `moves` INT UNSIGNED NOT NULL,
  `score` DECIMAL(5,2) DEFAULT NULL, -- calculé côté requête ou trigger
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_player_name` (`player_name`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `games` (`id`, `player_name`, `pairs`, `moves`, `created_at`) VALUES
(1, 'Sylvain', 3, 9, '2025-11-24 12:59:10'),
(2, 'A-zix_MVC', 3, 6, '2025-11-24 13:00:34'),
(3, 'Alain', 3, 30, '2025-11-24 13:05:46'),
(4, 'Sylvain', 3, 4, '2025-11-24 13:37:42'),
(5, 'A-zix_MVC', 3, 5, '2025-11-24 13:38:10'),
(6, 'Alain', 3, 4, '2025-11-24 13:50:16'),
(7, 'Sylverster', 3, 15, '2025-11-24 13:58:02'),
(8, 'Christophe', 3, 1, '2025-11-24 14:03:35'),
(9, 'A-zix_MVC', 12, 10, '2025-11-24 14:05:22'),
(10, 'Sylvain', 6, 0, '2025-11-24 14:16:23'),
(11, 'Sylvain', 3, 2, '2025-11-24 14:18:38'),
(12, 'Arthur', 3, 0, '2025-11-24 14:21:52'),
(13, 'Kappa_Geist', 3, 7, '2025-11-25 08:15:28'),
(14, 'Kappa_Geist', 3, 5, '2025-11-25 08:16:45'),
(15, 'Okay_Roh-Zen', 3, 4, '2025-11-25 08:22:55'),
(16, 'Sylvain', 3, 0, '2025-11-25 08:23:20'),
(17, 'Christophe', 3, 0, '2025-11-25 08:41:54');

-- --------------------------------------------------------
-- Table structure for table `game_cards`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `game_cards`;
CREATE TABLE `game_cards` (
  `game_id` INT NOT NULL,
  `card_id` INT NOT NULL,
  PRIMARY KEY (`game_id`,`card_id`),
  KEY `idx_game_id` (`game_id`),
  KEY `idx_card_id` (`card_id`),
  CONSTRAINT `game_cards_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  CONSTRAINT `game_cards_ibfk_2` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- View structure for leaderboard
-- --------------------------------------------------------

DROP VIEW IF EXISTS `leaderboard`;
CREATE VIEW `leaderboard` AS
SELECT g.player_name, (g.moves / g.pairs) AS score, g.created_at
FROM games g
ORDER BY score ASC
LIMIT 10;

<?php
/**
 * Vue : Partie en cours du Jeu Memory
 * ------------------------------------
 * Variables reçues :
 * - $gameStarted : bool (true si partie en cours)
 * - $cards : tableau d'objets Card
 * - $moves : nombre de coups
 * - $score : score calculé
 * - $playerName : nom du joueur
 * - $gameId : ID de la partie en cours
 */
?>

<h1><?= htmlspecialchars($title ?? 'Jeu Memory', ENT_QUOTES, 'UTF-8') ?></h1>

<?php if (isset($_SESSION['error'])): ?>
    <div class="error-message">
        ⚠️ <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($gameStarted) && $gameStarted): ?>
    <!-- Partie en cours -->
    <div class="game-info">
        <p><strong>Joueur :</strong> <?= htmlspecialchars($playerName ?? 'Joueur', ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Nombre de coups :</strong> <span id="moves"><?= htmlspecialchars($moves ?? 0, ENT_QUOTES, 'UTF-8') ?></span></p>
        <?php if (isset($score) && $score > 0): ?>
            <p><strong>Score :</strong> <?= number_format($score, 2) ?></p>
        <?php endif; ?>
    </div>

    <?php if (isset($cards) && !empty($cards)): ?>
        <div class="board">
            <?php foreach ($cards as $card): ?>
                <div class="card <?= htmlspecialchars($card->getStatus(), ENT_QUOTES, 'UTF-8') ?>" 
                     data-card-id="<?= $card->getId() ?>"
                     data-card-name="<?= htmlspecialchars($card->getName(), ENT_QUOTES, 'UTF-8') ?>">
                    <div class="card-inner">
                        <div class="card-front">
                            <img src="<?= url('/assets/images/Coquillage.png') ?>" alt="carte cachée">
                        </div>
                        <div class="card-back">
                            <img src="<?= url('/assets/images/' . htmlspecialchars($card->getImage(), ENT_QUOTES, 'UTF-8')) ?>" 
                                 alt="<?= htmlspecialchars($card->getName(), ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="error-message">❌ Erreur : aucune carte disponible</p>
    <?php endif; ?>

    <div class="actions">
        <a href="<?= url('/') ?>" >🏠 Accueil</a>
        <a href="<?= url('/game/reset') ?>">🔄 Nouvelle partie</a>
        <a href="<?= url('/leaderboard') ?>">🏆 Hall of Fame</a>
        <a href="<?= url('/profile?player=' . urlencode($profilePlayer)) ?>">👤 Mon profil</a>
    </div>

    <script src="<?= url('/assets/js/game.js') ?>"></script>

<?php else: ?>
    <!-- Formulaire de démarrage -->
             <h2>Démarrer une nouvelle partie :</h2>
    <div class="game-start">

        <form method="POST" action="<?= url('/game/play') ?>">
            <div class="form-group">
                <label for="playerName">Nom du joueur :</label>
                <input type="text" 
                       id="playerName" 
                       name="playerName" 
                       required 
                       maxlength="50"
                       pattern="[a-zA-Z0-9\s\-_]+"
                       placeholder="Entrez votre nom"
                       title="Lettres, chiffres, espaces, tirets uniquement">
            </div>
            <div class="form-group">
                <label for="pairs">Niveau de difficulté :</label>
                <select id="pairs" name="pairs" required>
                    <option value="3" selected>🟢 Facile (6 cartes)</option>
                    <option value="6" >🟡 Moyen (12 cartes)</option>
                    <option value="9">🟠 Difficile (18 cartes)</option>
                    <option value="12">🔴 Ultime (24 cartes)</option>
                </select>
            </div>
            <button type="submit" class="btn-start-game">
                <img src="<?= url('/assets/images/Logo-Memory.png') ?>" 
                     alt="" 
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                <span style="display: none;">🎴</span>
                Commencer
            </button>
        
        </form>
    </div>

    <div class="actions">
        <a href="<?= url('/') ?>" >🏠 Retour à l'accueil</a>
        <a href="<?= url('/leaderboard') ?>">🏆 Hall of Fame</a>
    </div>
<?php endif; ?>

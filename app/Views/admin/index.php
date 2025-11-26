<?php
/**
 * Vue : Administration du jeu Memory
 */
?>

<h1><?= htmlspecialchars($title ?? 'Administration', ENT_QUOTES, 'UTF-8') ?></h1>

<?php if (isset($_GET['deleted'])): ?>
    <div class="success-message">
        ✅ <?= (int)$_GET['deleted'] ?> partie(s) supprimée(s) avec succès !
    </div>
<?php endif; ?>

<div class="admin-container">
    <!-- Reset complet du Hall of Fame -->
    <div class="admin-card danger">
        <h2>⚠️ Reset complet du Hall of Fame</h2>
        <p>Cette action supprime <strong>TOUTES</strong> les parties enregistrées.</p>
        
        <form method="POST" action="<?= url('/admin/reset') ?>" onsubmit="return confirm('Êtes-vous SÛR de vouloir supprimer TOUTES les parties ? Cette action est irréversible !');">
            <div class="form-group">
                <label for="confirm">Tapez "RESET" pour confirmer :</label>
                <input type="text" id="confirm" name="confirm" required placeholder="RESET">
            </div>
            <button type="submit" class="btn-danger">🗑️ Supprimer toutes les parties</button>
        </form>
    </div>

    <!-- Nettoyage des anciennes parties -->
    <div class="admin-card warning">
        <h2>🧹 Nettoyer les anciennes parties</h2>
        <p>Supprimer les parties plus anciennes que X jours.</p>
        
        <form method="POST" action="<?= url('/admin/clean') ?>">
            <div class="form-group">
                <label for="days">Nombre de jours :</label>
                <select id="days" name="days">
                    <option value="7">7 jours</option>
                    <option value="30" selected>30 jours</option>
                    <option value="90">90 jours</option>
                    <option value="180">180 jours</option>
                </select>
            </div>
            <button type="submit" class="btn-warning">🧹 Nettoyer</button>
        </form>
    </div>

    <!-- Statistiques -->
    <div class="admin-card info">
        <h2>📊 Statistiques</h2>
        <?php
        $pdo = \Core\Database::getPdo();
        $totalGames = $pdo->query('SELECT COUNT(*) FROM games')->fetchColumn();
        $totalPlayers = $pdo->query('SELECT COUNT(DISTINCT player_name) FROM games')->fetchColumn();
        $avgMoves = $pdo->query('SELECT AVG(moves) FROM games')->fetchColumn();
        ?>
        <ul>
            <li><strong>Total de parties :</strong> <?= $totalGames ?></li>
            <li><strong>Joueurs uniques :</strong> <?= $totalPlayers ?></li>
            <li><strong>Moyenne de coups :</strong> <?= number_format($avgMoves, 2) ?></li>
        </ul>
    </div>
</div>

<div class="actions">
    <a href="<?= url('/') ?>" >🏠 Retour à l'accueil</a>
    <a href="<?= url('/leaderboard') ?>">🏆 Voir le Hall of Fame</a>
</div>
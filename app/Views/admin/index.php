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
        
        <form method="POST" action="/admin/reset" onsubmit="return confirm('Êtes-vous SÛR de vouloir supprimer TOUTES les parties ? Cette action est irréversible !');">
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
        
        <form method="POST" action="/admin/clean">
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
    <a href="/">🏠 Retour à l'accueil</a>
    <a href="/leaderboard">🏆 Voir le Hall of Fame</a>
</div>

<style>
.admin-container {
    max-width: 1000px;
    margin: 40px auto;
    display: grid;
    gap: 30px;
}

.admin-card {
    background: white;
    padding: 30px;
    border: 4px solid #8b4513;
    box-shadow: 10px 10px 0 rgba(139, 69, 19, 0.2);
}

.admin-card.danger {
    border-color: #d4524e;
}

.admin-card.warning {
    border-color: #d97706;
}

.admin-card.info {
    border-color: #2d6a3f;
}

.admin-card h2 {
    margin-bottom: 15px;
    color: #8b4513;
    text-align: center;
}

.admin-card p {
    margin-bottom: 20px;
    color: #4a3528;
    text-align: center;
}

.admin-card ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.admin-card ul li {
    padding: 10px 0;
    border-bottom: 1px solid #f5e6d3;
    color: #2c1810;
}

.admin-card ul li:last-child {
    border-bottom: none;
}

.admin-card .form-group {
    margin-bottom: 20px;
    text-align: left;
}

.admin-card .form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #8b4513;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.9em;
}

.admin-card .form-group input,
.admin-card .form-group select {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border: 3px solid #8b4513;
    background: #f5e6d3;
    transition: border 0.3s;
    font-family: inherit;
}

.admin-card .form-group input:focus,
.admin-card .form-group select:focus {
    outline: none;
    border-color: #d4524e;
    background: #fff;
}

.btn-danger, .btn-warning {
    width: 100%;
    padding: 15px;
    border: 3px solid #8b4513;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 2px;
    box-shadow: 6px 6px 0 rgba(139, 69, 19, 0.3);
    transition: all 0.3s;
}

.btn-danger {
    background: #d4524e;
    color: white;
}

.btn-danger:hover {
    background: #b83f3b;
    transform: translate(3px, 3px);
    box-shadow: 3px 3px 0 rgba(139, 69, 19, 0.3);
}

.btn-danger:active {
    transform: translate(6px, 6px);
    box-shadow: none;
}

.btn-warning {
    background: #d97706;
    color: white;
}

.btn-warning:hover {
    background: #b86005;
    transform: translate(3px, 3px);
    box-shadow: 3px 3px 0 rgba(139, 69, 19, 0.3);
}

.btn-warning:active {
    transform: translate(6px, 6px);
    box-shadow: none;
}

.success-message {
    background: #2d6a3f;
    color: white;
    padding: 20px;
    text-align: center;
    margin: 20px auto;
    max-width: 600px;
    border: 3px solid #1a5c2e;
    font-weight: bold;
    box-shadow: 6px 6px 0 rgba(45, 106, 63, 0.3);
}
</style>

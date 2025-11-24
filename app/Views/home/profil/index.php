<?php
/**
 * Vue : Profil du joueur - Historique des parties
 * ------------------------------------------------
 * Variables reçues :
 * - $playerName : nom du joueur
 * - $games : tableau associatif des parties du joueur
 * - $title : titre de la page
 */
?>

<h1><?= htmlspecialchars($title ?? 'Profil', ENT_QUOTES, 'UTF-8') ?></h1>

<h2>Historique des parties de <?= htmlspecialchars($playerName ?? 'Joueur', ENT_QUOTES, 'UTF-8') ?></h2>

<?php if (!empty($games)): ?>
    <div class="profile-stats">
        <div class="stat-card">
            <div class="stat-icon">
                <img src="/assets/images/Logo-Memory.png" 
                     alt="Parties" 
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
                <span style="display: none;">🎴</span>
            </div>
            <div class="stat-value"><?= count($games) ?></div>
            <div class="stat-label">Parties jouées</div>
        </div>
        
        <?php
        $totalMoves = array_sum(array_column($games, 'moves'));
        $avgScore = count($games) > 0 ? array_sum(array_column($games, 'score')) / count($games) : 0;
        $bestScore = count($games) > 0 ? min(array_column($games, 'score')) : 0;
        ?>
        
        <div class="stat-card">
            <div class="stat-icon">🎯</div>
            <div class="stat-value"><?= number_format($avgScore, 2) ?></div>
            <div class="stat-label">Score moyen</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">⭐</div>
            <div class="stat-value"><?= number_format($bestScore, 2) ?></div>
            <div class="stat-label">Meilleur score</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">🔢</div>
            <div class="stat-value"><?= $totalMoves ?></div>
            <div class="stat-label">Coups totaux</div>
        </div>
    </div>

    <div class="games-history">
        <h3>Historique détaillé</h3>
        <table class="profile-table">
            <thead>
                <tr>
                    <th>Partie #</th>
                    <th>Paires</th>
                    <th>Coups</th>
                    <th>Score</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($games as $game): ?>
                    <tr>
                        <td class="game-id">#<?= $game['id'] ?></td>
                        <td><?= $game['pairs'] ?></td>
                        <td><?= $game['moves'] ?></td>
                        <td class="score <?= $game['score'] < 2 ? 'excellent' : ($game['score'] < 3 ? 'good' : 'normal') ?>">
                            <?= number_format($game['score'], 2) ?>
                        </td>
                        <td class="date"><?= date('d/m/Y H:i', strtotime($game['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="no-games">
        <div class="no-games-icon">😕</div>
        <p>Aucune partie jouée pour le moment.</p>
        <p>Lancez-vous et établissez votre premier record !</p>
        <a href="/game" class="btn-start-game">
            <img src="/assets/images/Logo-Memory.png" 
                 alt="" 
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
            <span style="display: none;">🎴</span>
            Commencer à jouer
        </a>
    </div>
<?php endif; ?>

<div class="actions">
    <a href="/">🏠 Retour à l'accueil</a>
    <a href="/game">🔄 Nouvelle partie</a>
    <a href="/leaderboard">🏆 Hall of Fame</a>
</div>
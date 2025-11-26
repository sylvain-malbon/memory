<?php
/**
 * Vue : Hall of Fame - Classement des meilleurs scores
 * -----------------------------------------------------
 * Variables reçues :
 * - $leaderboard : tableau associatif des 10 meilleurs scores
 */
?>

<h1>🏆 <?= htmlspecialchars($title ?? 'Hall of Fame', ENT_QUOTES, 'UTF-8') ?> 🏆</h1>

<p class="leaderboard-description">Plus le score est bas, meilleure est la performance (coups / paires).</p>
<h2>Les 10 meilleurs scores :</h2>

<?php if (isset($leaderboard) && !empty($leaderboard)): ?>
    <div class="leaderboard-container">
        <table class="leaderboard-table">
            <thead>
                <tr>
                    <th class="rank">Rang</th>
                    <th class="player">Joueur</th>
                    <th class="score">Score</th>
                    <th class="date">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaderboard as $index => $entry): ?>
                    <tr class="rank-<?= $index + 1 ?>">
                        <td class="rank">
                            <?php if ($index === 0): ?>
                                🥇
                            <?php elseif ($index === 1): ?>
                                🥈
                            <?php elseif ($index === 2): ?>
                                🥉
                            <?php else: ?>
                                <?= $index + 1 ?>
                            <?php endif; ?>
                        </td>
                        <td class="player">
                            <a href="<?= url('/profile?player=' . urlencode($entry['player_name'])) ?>">
                                <?= htmlspecialchars($entry['player_name'], ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        </td>
                        <td class="score">
                            <?= number_format($entry['score'], 2) ?>
                        </td>
                        <td class="date">
                            le
                            <?= date('d.m.Y', strtotime($entry['created_at'])) ?>
                            à
                            <?= date('H:i', strtotime($entry['created_at'])) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="no-data">
        <p>😕 Aucune partie enregistrée pour le moment.</p>
        <p>Soyez le premier à jouer !</p>
    </div>
<?php endif; ?>

<div class="actions">
    <a href="<?= url('/') ?>" class="btn">🏠 Accueil</a>
    <a href="<?= url('/game') ?>" class="btn btn-primary">
        <img src="<?= url('/assets/images/Logo-Memory.png') ?>" 
             alt="" 
             onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
        <span style="display: none;">🎴</span>
        Jouer maintenant
    </a>
</div>
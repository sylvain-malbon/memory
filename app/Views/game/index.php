<?php
/**
 * Vue : Partie en cours du Memory Game
 * ------------------------------------
 * Variables reçues :
 * - $cards : tableau d'objets Card
 * - $moves : nombre de coups
 * - $score : score calculé
 * - $playerName : nom du joueur
 */
?>

<h1>Memory Game</h1>

<p>Nombre de coups : <?= htmlspecialchars($moves ?? 0, ENT_QUOTES, 'UTF-8') ?></p>

<?php if (isset($score)): ?>
    <p>Score : <?= htmlspecialchars($score, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<div class="board">
    <?php foreach ($cards as $card): ?>
        <div class="card <?= htmlspecialchars($card->getStatus(), ENT_QUOTES, 'UTF-8') ?>">
            <img src="/images/<?= htmlspecialchars($card->getImage(), ENT_QUOTES, 'UTF-8') ?>" 
                 alt="<?= htmlspecialchars($card->getName(), ENT_QUOTES, 'UTF-8') ?>">
        </div>
    <?php endforeach; ?>
</div>

<div class="actions">
    <a href="/games?action=restart">Relancer la partie</a> |
    <a href="/leaderboard">Hall of Fame</a> |
    <a href="/profiles?player=<?= urlencode($playerName ?? '') ?>">Mon profil</a>
</div>

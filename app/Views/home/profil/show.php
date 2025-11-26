<h1>Détail de la partie #<?= $game->getId(); ?></h1>

<ul>
    <li>Joueur : <?= htmlspecialchars($game->getPlayerName(), ENT_QUOTES, 'UTF-8'); ?></li>
    <li>Nombre de paires : <?= $game->getPairs(); ?></li>
    <li>Nombre de coups : <?= $game->getMoves(); ?></li>
    <li>Score : <?= $game->getScore(); ?></li>
    <li>Date : <?= $game->getCreatedAt(); ?></li>
</ul>

<div class="actions">
    <a href="<?= url('/game') ?>">Retour au jeu</a>
    <a href="<?= url('/leaderboard') ?>">Hall of Fame</a>
    <a href="<?= url('/profile?player=' . urlencode($game->getPlayerName())) ?>">Profil du joueur</a>
</div>

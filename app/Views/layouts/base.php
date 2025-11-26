<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title><?= isset($title) ? htmlspecialchars($title, ENT_QUOTES, 'UTF-8') : 'Mini MVC' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= url('/assets/css/style.css') ?>">
</head>

<body>

  <nav>
    <div class="nav-texture"></div>
    <a class="logo-style" href="<?= url('/') ?>" aria-label="Retour à l'accueil">
      <img src="<?= url('/assets/images/Logo-Memory.png') ?>" 
           alt="Memory Hanafuda - Logo du jeu" 
           class="nav-logo"
           onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
      <span class="nav-logo-emoji" style="display: none;" role="img" aria-label="Carte Hanafuda">🎴</span>
    </a>
    <div class="nav-links">
        <a href="<?= url('/') ?>">Accueil</a> 
        <a href="<?= url('/game/reset') ?>">Nouvelle partie</a>
        <a href="<?= url('/leaderboard') ?>">Hall of Fame</a>
        <a href="<?= url('/profile') ?>">Mon profil</a>
        <a href="<?= url('/admin') ?>" class="nav-admin">⚙️ Admin</a>
    </div>
  </nav>

  <main>
    <?= $content ?>
  </main>

</body>
</html>

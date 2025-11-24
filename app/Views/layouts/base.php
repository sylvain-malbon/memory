<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title><?= isset($title) ? htmlspecialchars($title, ENT_QUOTES, 'UTF-8') : 'Mini MVC' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

  <nav>
    <a href="/" aria-label="Retour à l'accueil">
      <img src="/assets/images/Logo-Memory.png" 
           alt="Memory Hanafuda - Logo du jeu" 
           class="nav-logo"
           onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
      <span class="nav-logo-emoji" style="display: none;" role="img" aria-label="Carte Hanafuda">🎴</span>
    </a>
<div class="nav-texture">
    <div class="nav-links">
    <a href="/">Accueil</a> 
    <a href="/game/reset">Nouvelle partie</a>
    <a href="/leaderboard">Hall of Fame</a>
    <a href="/profile">Mon profil</a>
    <a href="/admin" class="nav-admin">⚙️ Admin</a>
    </div>
</div>
  </nav>

  <main>
    <?= $content ?>
  </main>

</body>

</html>

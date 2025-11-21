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
    <a href="/">Accueil</a> 
    <a href="/games">Nouvelle partie</a>
    <a href="/leaderboard">Hall of Fame</a>
    <a href="/profiles">Mon profil</a>
  </nav>

  <main>
    <?= $content ?>
  </main>

</body>

</html>

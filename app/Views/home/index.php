    <h1><?= htmlspecialchars($title ?? 'Accueil', ENT_QUOTES, 'UTF-8') ?></h1>
    <div class="home-welcome">

    
    <p>Bienvenue dans le jeu Memory 🎮</p>
    <p>Choisissez une action pour commencer :</p>

    <nav>
        <ul>
            <li><a href="/game">▶️ Lancer une nouvelle partie</a></li>
            <li><a href="/leaderboard">🏆 Voir le Hall of Fame</a></li>
            <li><a href="/profile?player=John">👤 Consulter mon profil</a></li>
        </ul>
    </nav>
</div>

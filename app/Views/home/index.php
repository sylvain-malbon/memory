<h1><?= htmlspecialchars($title ?? 'Accueil', ENT_QUOTES, 'UTF-8') ?></h1>
  
    
<p class="home-description">Bienvenue dans le jeu <i>Memory – Nippon Edition</i> inspiré du jeu des coquillages 
    <img src="/assets/images/Logo-Memory.png" 
         alt="Hanafuda" 
         class="logo-inline"
         onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
    <span class="logo-inline-fallback">🎴</span><br>
Choisissez une action pour commencer :</p>

    <div class="home-welcome">
    <nav>
        <ul>
            <li><a href="/game">🔄 Lancer une nouvelle partie</a></li>
            <li><a href="/leaderboard">🏆 Voir le Hall of Fame</a></li>
            <li>
                <?php 
                $profilePlayer = $_SESSION['playerName'] ?? 'Joueur';
                ?>
                <a href="/profile?player=<?= urlencode($profilePlayer) ?>">👤 Consulter mon profil</a>
            </li>
        </ul>
    </nav>
</div>

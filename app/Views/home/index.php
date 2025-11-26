<h1><?= htmlspecialchars($title ?? 'Accueil', ENT_QUOTES, 'UTF-8') ?></h1>
  
    
<p class="home-description">Bienvenue dans l'édition de Memory inspirée du <i>jeu des coquillages</i> japonais 
    <img src="<?= url('/assets/images/Logo-Memory.png') ?>" 
         alt="Hanafuda" 
         class="logo-inline"
         onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
    <span class="logo-inline-fallback">🎴</span><br></p>
<h2>Choisissez une action pour commencer :</h2>

    <div class="home-welcome">
    <nav>
        <ul>
            <li><a href="<?= url('/game') ?>">🔄 Lancer une nouvelle partie</a></li>
            <li><a href="<?= url('/leaderboard') ?>">🏆 Voir le Hall of Fame</a></li>
            <li>
                <?php 
                $profilePlayer = $_SESSION['playerName'] ?? 'Joueur';
                ?>
                <a href="<?= url('/profile?player=' . urlencode($profilePlayer)) ?>">👤 Consulter mon profil</a>
            </li>
        </ul>
    </nav>
</div>

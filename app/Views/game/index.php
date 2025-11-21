<?php
/**
 * Vue : Partie en cours du Jeu Memory
 * ------------------------------------
 * Variables reçues :
 * - $cards : tableau d'objets Card
 * - $moves : nombre de coups
 * - $score : score calculé
 * - $playerName : nom du joueur
 * - $gameId : ID de la partie en cours
 */
?>

<h1><?= htmlspecialchars($title ?? 'Jeu Memory', ENT_QUOTES, 'UTF-8') ?></h1>

<div class="game-info">
    <p><strong>Joueur :</strong> <?= htmlspecialchars($playerName ?? 'Joueur', ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Nombre de coups :</strong> <span id="moves"><?= htmlspecialchars($moves ?? 0, ENT_QUOTES, 'UTF-8') ?></span></p>
    <?php if (isset($score) && $score > 0): ?>
        <p><strong>Score :</strong> <?= number_format($score, 2) ?></p>
    <?php endif; ?>
</div>

<?php if (isset($cards) && !empty($cards)): ?>
    <div class="board">
        <?php foreach ($cards as $card): ?>
            <div class="card <?= htmlspecialchars($card->getStatus(), ENT_QUOTES, 'UTF-8') ?>" 
                 data-card-id="<?= $card->getId() ?>"
                 data-card-name="<?= htmlspecialchars($card->getName(), ENT_QUOTES, 'UTF-8') ?>">
                <div class="card-inner">
                    <div class="card-front">
                        <img src="/assets/images/card-back.png" alt="carte cachée">
                    </div>
                    <div class="card-back">
                        <img src="/assets/images/<?= htmlspecialchars($card->getImage(), ENT_QUOTES, 'UTF-8') ?>" 
                             alt="<?= htmlspecialchars($card->getName(), ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="game-start">
        <h2>Démarrer une nouvelle partie</h2>
        <form method="GET" action="/game/play">
            <div class="form-group">
                <label for="playerName">Nom du joueur :</label>
                <input type="text" id="playerName" name="playerName" required placeholder="Entrez votre nom" value="<?= htmlspecialchars($_GET['playerName'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="form-group">
                <label for="pairs">Nombre de paires :</label>
                <select id="pairs" name="pairs">
                    <option value="3">Facile (3 paires - 6 cartes)</option>
                    <option value="6" selected>Moyen (6 paires - 12 cartes)</option>
                    <option value="9">Difficile (9 paires - 18 cartes)</option>
                    <option value="12">Ultime (12 paires - 24 cartes)</option>
                </select>
            </div>
            <button type="submit" class="btn-start">Commencer</button>
        </form>
    </div>
<?php endif; ?>

<div class="actions">
    <a href="/">🏠 Accueil</a>
    <a href="/game">🔄 Nouvelle partie</a>
    <a href="/leaderboard">🏆 Hall of Fame</a>
    <?php 
    // Utiliser la session si disponible, sinon le paramètre de la vue
    $profilePlayer = $_SESSION['playerName'] ?? $playerName ?? 'Joueur';
    ?>
    <a href="/profile?player=<?= urlencode($profilePlayer) ?>">👤 Mon profil</a>
</div>

<script>
// JavaScript pour le jeu Memory
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card');
    let firstCard = null;
    let secondCard = null;
    let lockBoard = false;

    cards.forEach(card => {
        card.addEventListener('click', flipCard);
    });

    function flipCard() {
        if (lockBoard) return;
        if (this === firstCard) return;
        if (this.classList.contains('matched')) return;

        this.classList.add('visible');

        if (!firstCard) {
            firstCard = this;
            return;
        }

        secondCard = this;
        lockBoard = true;

        checkForMatch();
    }

    function checkForMatch() {
        const isMatch = firstCard.dataset.cardName === secondCard.dataset.cardName;

        if (isMatch) {
            disableCards();
        } else {
            unflipCards();
        }

        // Incrémenter le compteur de coups
        const movesElement = document.getElementById('moves');
        const currentMoves = parseInt(movesElement.textContent);
        movesElement.textContent = currentMoves + 1;

        // Sauvegarder en BDD via PHP session
        fetch('/game/update-moves', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'}
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                console.log('Score sauvegardé:', data.moves, 'coups');
                console.log('Session active:', data.playerName, 'GameID:', data.gameId);
            } else {
                console.error('Erreur session:', data.error);
            }
        })
        .catch(err => console.error('Erreur sauvegarde:', err));
    }

    function disableCards() {
        firstCard.classList.add('matched');
        secondCard.classList.add('matched');

        resetBoard();
        checkWin();
    }

    function unflipCards() {
        setTimeout(() => {
            firstCard.classList.remove('visible');
            secondCard.classList.remove('visible');
            resetBoard();
        }, 1000);
    }

    function resetBoard() {
        [firstCard, secondCard] = [null, null];
        lockBoard = false;
    }

    function checkWin() {
        const allMatched = Array.from(cards).every(card => card.classList.contains('matched'));
        if (allMatched) {
            setTimeout(() => {
                alert('🎉 Félicitations ! Vous avez gagné !');
            }, 500);
        }
    }
});
</script>

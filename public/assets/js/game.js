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
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
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
<?php
namespace App\Controllers;

use Core\BaseController;

/**
 * Classe HomeController
 * ----------------------
 * Contrôleur responsable de la page d'accueil et des infos générales.
 * Hérite de BaseController afin de bénéficier des méthodes utilitaires
 * comme render() pour afficher les vues.
 */
class HomeController extends BaseController
{
    /**
     * Page d'accueil
     *
     * @return void
     */
    public function index(): void
    {
        // On affiche la vue "home/index.php"
        // avec un titre et éventuellement des liens vers le jeu
        $this->render('home/index', [
            'title' => 'Jeu Memory Kai-awase',
            'subtitle' => 'Choisissez une partie, consultez le classement ou votre profil'
        ]);
    }

    /**
     * Page "À propos"
     *
     * @return void
     */
    public function about(): void
    {
        $this->render('home/about', [
            'title' => 'À propos du jeu Memory',
            'subtitle' => 'Un petit jeu de paires en version 2.0'
        ]);
    }
}

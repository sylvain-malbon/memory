<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/config.php';
require_once __DIR__ . '/../core/helpers.php';

use Core\Router;
use Core\Config;

$router = new Router();

// Déclaration des routes
$router->get('/', 'App\Controllers\HomeController@index');
$router->get('/game', 'App\Controllers\GameController@start');
$router->post('/game/play', 'App\Controllers\GameController@play');
$router->get('/game/reset', 'App\Controllers\GameController@reset');
$router->post('/game/update-moves', 'App\Controllers\GameController@updateMoves');
$router->get('/leaderboard', 'App\Controllers\LeaderboardController@index');
$router->get('/profile', 'App\Controllers\ProfileController@show');
$router->get('/admin', 'App\Controllers\AdminController@index');
$router->post('/admin/reset', 'App\Controllers\AdminController@resetLeaderboard');
$router->post('/admin/clean', 'App\Controllers\AdminController@cleanOldGames');

// Récupérer l'URI et la méthode HTTP
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Dispatcher la requête
$router->dispatch($uri, $method);

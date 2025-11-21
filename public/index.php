<?php
session_start();

require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->safeLoad();

use Core\Router;

$router = new Router();

$router->get('/', 'App\\Controllers\\HomeController@index');

$router->get('/game', 'App\\Controllers\\GameController@start'); 
$router->get('/game/play', 'App\\Controllers\\GameController@play'); 
$router->post('/game/update', 'App\\Controllers\\GameController@update'); 
$router->post('/game/update-moves', 'App\\Controllers\\GameController@updateMoves'); 

$router->get('/leaderboard', 'App\\Controllers\\LeaderboardController@index'); 

$router->get('/profile', 'App\\Controllers\\ProfileController@show'); 

// Routes d'administration
$router->get('/admin', 'App\\Controllers\\AdminController@index'); 
$router->post('/admin/reset', 'App\\Controllers\\AdminController@resetLeaderboard'); 
$router->post('/admin/clean', 'App\\Controllers\\AdminController@cleanOldGames'); 

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

<?php

require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->safeLoad();

use Core\Router;

$router = new Router();

$router->get('/', 'App\\Controllers\\HomeController@index');

$router->get('/game', 'App\\Controllers\\GameController@start'); 

$router->get('/leaderboard', 'App\\Controllers\\LeaderboardController@index'); 

$router->get('/profile', 'App\\Controllers\\ProfileController@show'); 

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

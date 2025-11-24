<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;

$router = new Router();

// Récupérer l'URI et la méthode HTTP
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Nettoyer l'URI (enlever le dossier si nécessaire)
$uri = parse_url($uri, PHP_URL_PATH);

// Dispatcher la requête
$router->dispatch($uri, $method);

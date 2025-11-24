<?php
namespace Core;

class Router
{
    private $routes = [
        '/' => ['controller' => 'HomeController', 'action' => 'index'],
        '/game' => ['controller' => 'GameController', 'action' => 'start'],
        '/game/reset' => ['controller' => 'GameController', 'action' => 'reset'],
        '/game/play' => ['controller' => 'GameController', 'action' => 'play'],
        '/game/update-moves' => ['controller' => 'GameController', 'action' => 'updateMoves'],
        '/leaderboard' => ['controller' => 'LeaderboardController', 'action' => 'index'],
        '/profile' => ['controller' => 'ProfileController', 'action' => 'show'],
        '/admin' => ['controller' => 'AdminController', 'action' => 'index'],
        '/admin/reset-leaderboard' => ['controller' => 'AdminController', 'action' => 'resetLeaderboard'],
        '/admin/cleanup-games' => ['controller' => 'AdminController', 'action' => 'cleanupGames'],
    ];

    public function dispatch(string $uri, string $method = 'GET')
    {
        // Enlever les paramètres de query string
        $uri = strtok($uri, '?');
        
        if (!isset($this->routes[$uri])) {
            http_response_code(404);
            echo "404 - Page non trouvée";
            return;
        }

        $route = $this->routes[$uri];
        $controllerName = "App\\Controllers\\" . $route['controller'];
        $action = $route['action'];

        if (!class_exists($controllerName)) {
            http_response_code(500);
            echo "Erreur : Le contrôleur $controllerName n'existe pas";
            return;
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $action)) {
            http_response_code(500);
            echo "Erreur : La méthode $action n'existe pas dans $controllerName";
            return;
        }

        $controller->$action();
    }
}

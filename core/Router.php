<?php
namespace Core;

class Router
{
    private array $routes = ['GET' => [], 'POST' => []];

    public function get(string $path, string $action): void
    {
        $this->routes['GET'][$path] = $action;
    }

    public function post(string $path, string $action): void
    {
        $this->routes['POST'][$path] = $action;
    }

    public function dispatch(string $uri, string $method): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';

        foreach ($this->routes[$method] ?? [] as $route => $action) {
            if ($route === $path) {
                [$class, $ctrlMethod] = explode('@', $action);
                if (!class_exists($class)) {
                    http_response_code(500);
                    echo "Erreur : Le contrôleur $class n'existe pas";
                    return;
                }
                $controller = new $class();
                if (!method_exists($controller, $ctrlMethod)) {
                    http_response_code(500);
                    echo "Erreur : La méthode $ctrlMethod n'existe pas dans $class";
                    return;
                }
                $controller->$ctrlMethod();
                return;
            }
        }

        http_response_code(404);
        echo "404 - Page non trouvée";
    }
}

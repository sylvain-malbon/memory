<?php
namespace Core;

class Config
{
    private static array $config = [];

    public static function load(): void
    {
        if (!self::$config) {
            $configFile = dirname(__DIR__) . '/config/config.php';
            if (file_exists($configFile)) {
                require $configFile;
                self::$config['BASE_PATH'] = defined('BASE_PATH') ? BASE_PATH : '/';
            }
        }
    }

    public static function get(string $key, $default = null)
    {
        self::load();
        return self::$config[$key] ?? $default;
    }

    // Ajout de la méthode url
    public static function url(string $path = ''): string
    {
        self::load();
        $base = rtrim(self::$config['BASE_PATH'] ?? '/', '/');
        $path = ltrim($path, '/');
        return $base . ($path ? '/' . $path : '');
    }
}

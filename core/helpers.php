<?php
if (!function_exists('url')) {
    function url(string $path = ''): string
    {
        return \Core\Config::url($path);
    }
}

<?php

$ROUTES = __DIR__ . '/routes/';
$CACHE = __DIR__ . '/cache/';
$HTML = __DIR__ . '/html/';
$CSS = __DIR__ . '/css/';

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = ['/' => $ROUTES . 'index.php'];

foreach (scandir($ROUTES) as $file) {
    if ($file === '.' || $file === '..') continue;

    $route = substr($file, 0, -4);
    $routes["/{$route}"] = $ROUTES . $file;
}

if (!array_key_exists($uri, $routes)) {
    http_response_code(404);
    die('<h1>404 not found</h1>');
}

require_once 'view.php';
require $routes[$uri];

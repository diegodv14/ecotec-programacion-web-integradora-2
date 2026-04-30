<?php

declare(strict_types=1);

use App\Controllers\InicioController;
use App\Controllers\ProductoController;
use App\Controllers\VentaController;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

if (file_exists(dirname(__DIR__, 2) . '/.env')) {
    Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2))->safeLoad();
}

session_start();

function app_url(string $path = ''): string
{
    $base = rtrim($_ENV['APP_URL'] ?? 'http://localhost:8000', '/');
    return $base . '/' . ltrim($path, '/');
}

function render(string $view, array $data = []): void
{
    extract($data, EXTR_SKIP);
    $viewPath = dirname(__DIR__) . '/Views/' . $view . '.php';
    require dirname(__DIR__) . '/Views/layout.php';
}

function dispatch(string $route): void
{
    $routes = [
        '' => [InicioController::class, 'index'],
        'productos' => [ProductoController::class, 'index'],
        'ventas' => [VentaController::class, 'index'],
    ];

    $handler = $routes[$route] ?? null;

    if ($handler === null) {
        http_response_code(404);
        render('errores/404', [
            'titulo' => 'Pagina no encontrada',
        ]);
        return;
    }

    [$controllerClass, $method] = $handler;
    $controller = new $controllerClass();
    $controller->{$method}();
}
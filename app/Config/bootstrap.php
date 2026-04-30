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

function csrf_token(): string
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verify_csrf(?string $token): bool
{
    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}

function flash_message(?string $type = null, ?string $message = null): ?array
{
    if ($type !== null && $message !== null) {
        $_SESSION['flash_message'] = [
            'type' => $type,
            'message' => $message,
        ];

        return null;
    }

    if (!isset($_SESSION['flash_message'])) {
        return null;
    }

    $flash = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);

    return $flash;
}

function consume_sale_sync(): ?array
{
    if (!isset($_SESSION['sale_sync'])) {
        return null;
    }

    $payload = $_SESSION['sale_sync'];
    unset($_SESSION['sale_sync']);

    return $payload;
}

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
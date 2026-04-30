<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;

require_once __DIR__ . '/../../vendor/autoload.php';

if (file_exists(__DIR__ . '/../../.env')) {
    Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2))->safeLoad();
}

$capsule = new Capsule();

$capsule->addConnection([
    'driver' => $_ENV['DB_CONNECTION'] ?? 'mysql',
    'host' => $_ENV['DB_HOST'] ?? 'mysql',
    'port' => (int) ($_ENV['DB_PORT'] ?? 3306),
    'database' => $_ENV['DB_DATABASE'] ?? 'inventario_ventas',
    'username' => $_ENV['DB_USERNAME'] ?? 'inventario_user',
    'password' => $_ENV['DB_PASSWORD'] ?? 'inventario_pass',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

return $capsule;
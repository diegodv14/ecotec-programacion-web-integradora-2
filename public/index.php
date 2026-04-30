<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/Config/bootstrap.php';

$route = trim((string) ($_GET['ruta'] ?? ''));
dispatch($route);
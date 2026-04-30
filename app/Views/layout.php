<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo ?? 'Inventario y ventas', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="<?= htmlspecialchars(app_url('public/assets/css/app.css'), ENT_QUOTES, 'UTF-8') ?>">
</head>
<body>
    <header class="site-header">
        <div class="container nav-bar">
            <a class="brand" href="<?= htmlspecialchars(app_url(), ENT_QUOTES, 'UTF-8') ?>">Inventario + Ventas</a>
            <nav class="nav-links">
                <a href="<?= htmlspecialchars(app_url(), ENT_QUOTES, 'UTF-8') ?>">Inicio</a>
                <a href="<?= htmlspecialchars(app_url('?ruta=productos'), ENT_QUOTES, 'UTF-8') ?>">Productos</a>
                <a href="<?= htmlspecialchars(app_url('?ruta=ventas'), ENT_QUOTES, 'UTF-8') ?>">Ventas</a>
            </nav>
        </div>
    </header>

    <main class="container page-shell">
        <?php require $viewPath; ?>
    </main>
</body>
</html>
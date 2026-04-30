<section class="section-card">
    <p class="eyebrow">Error</p>
    <h1><?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?></h1>
    <p class="lead">La ruta solicitada no existe dentro del sistema.</p>
    <a class="button primary" href="<?= htmlspecialchars(app_url(), ENT_QUOTES, 'UTF-8') ?>">Volver al inicio</a>
</section>
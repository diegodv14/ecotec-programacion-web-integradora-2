<section class="hero">
    <p class="eyebrow">Sistema web</p>
    <h1><?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?></h1>
    <p class="lead"><?= htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8') ?></p>

    <div class="actions">
        <a class="button primary" href="<?= htmlspecialchars(app_url('?ruta=productos'), ENT_QUOTES, 'UTF-8') ?>">Ir a productos</a>
        <a class="button secondary" href="<?= htmlspecialchars(app_url('?ruta=ventas'), ENT_QUOTES, 'UTF-8') ?>">Ir a ventas</a>
    </div>
</section>

<section class="cards-grid">
    <article class="card">
        <h2>Productos</h2>
        <p>La siguiente iteracion agregara formularios, validaciones y persistencia del modulo de inventario.</p>
    </article>
    <article class="card">
        <h2>Ventas</h2>
        <p>La base de navegacion ya separa el modulo que luego usara Eloquent para registrar ventas.</p>
    </article>
</section>
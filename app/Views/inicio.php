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
        <p>CRUD completo en el navegador con localStorage, validaciones obligatorias y métricas de inventario.</p>
    </article>
    <article class="card">
        <h2>Ventas</h2>
        <p>Formulario conectado al inventario, validaciones de stock y persistencia en MySQL mediante Eloquent ORM.</p>
    </article>
    <article class="card">
        <h2>Base de datos</h2>
        <p>Docker Compose levanta solo MySQL y el script SQL inicializa la tabla de ventas para el proyecto.</p>
    </article>
    <article class="card">
        <h2>Entorno local</h2>
        <p>El proyecto se puede ejecutar con PHP y Composer localmente usando el script servidor definido en Composer.</p>
    </article>
</section>
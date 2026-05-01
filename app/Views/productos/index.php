<section class="products-layout">
    <article class="section-card product-form-card">
        <p class="eyebrow">Modulo 1</p>
        <h1><?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?></h1>
        <p class="lead"><?= htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8') ?></p>
        <p class="form-mode" id="modo-formulario">Modo actual: creación de producto</p>

        <form id="producto-form" class="stack-form" novalidate>
            <input id="producto-id" type="hidden">

            <div class="field-group">
                <label for="nombre">Nombre</label>
                <input id="nombre" type="text" maxlength="80" placeholder="Ej. Monitor 24 pulgadas">
            </div>

            <div class="field-group">
                <label for="stock">Stock</label>
                <input id="stock" type="number" min="0" step="1" placeholder="0">
            </div>

            <div class="field-group">
                <label for="precio">Precio</label>
                <input id="precio" type="number" min="0.01" step="0.01" placeholder="0.00">
            </div>

            <div class="button-row">
                <button class="button primary" type="submit">Guardar producto</button>
                <button class="button secondary" type="button" id="cancelar-edicion">Cancelar</button>
            </div>

            <div id="producto-mensaje" class="notice" hidden></div>
        </form>
    </article>

    <article class="section-card product-list-card">
        <div class="list-header">
            <div>
                <p class="eyebrow">Listado</p>
                <h2>Productos registrados</h2>
            </div>
            <span class="counter-pill" id="contador-productos">0 productos</span>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-label">Inventario total</span>
                <strong id="stat-stock">0 unidades</strong>
            </div>
            <div class="stat-card">
                <span class="stat-label">Valor estimado</span>
                <strong id="stat-value">$0.00</strong>
            </div>
            <div class="stat-card">
                <span class="stat-label">Stock bajo</span>
                <strong id="stat-low-stock">0 productos</strong>
            </div>
        </div>

        <div id="estado-vacio" class="notice">No hay productos registrados todavía.</div>

        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Stock</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-productos"></tbody>
            </table>
        </div>
    </article>
</section>

<script src="<?= htmlspecialchars(app_url('assets/js/productos.js'), ENT_QUOTES, 'UTF-8') ?>"></script>
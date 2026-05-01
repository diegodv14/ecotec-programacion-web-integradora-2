<section class="products-layout">
    <article class="section-card product-form-card">
        <p class="eyebrow">Modulo 2</p>
        <h1><?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?></h1>
        <p class="lead"><?= htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8') ?></p>

        <?php if (($flash ?? null) !== null): ?>
            <div class="notice <?= htmlspecialchars((string) $flash['type'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars((string) $flash['message'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form id="venta-form" class="stack-form" method="post" action="<?= htmlspecialchars(app_url('?ruta=ventas'), ENT_QUOTES, 'UTF-8') ?>" novalidate>
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="product_id" id="product_id">
            <input type="hidden" name="product_name" id="product_name">
            <input type="hidden" name="unit_price" id="unit_price">
            <input type="hidden" name="available_stock" id="available_stock">

            <div class="field-group">
                <label for="product-selector">Producto</label>
                <select id="product-selector" class="text-input">
                    <option value="">Selecciona un producto</option>
                </select>
            </div>

            <div class="field-group">
                <label for="customer_name">Cliente</label>
                <input id="customer_name" name="customer_name" type="text" maxlength="100" placeholder="Nombre del cliente">
            </div>

            <div class="field-group">
                <label for="quantity">Cantidad</label>
                <input id="quantity" name="quantity" type="number" min="1" step="1" placeholder="1">
            </div>

            <div class="notice" id="venta-resumen">Selecciona un producto para ver stock y precio disponible.</div>
            <div id="venta-mensaje" class="notice" hidden></div>

            <div class="button-row">
                <button class="button primary" type="submit">Registrar venta</button>
            </div>
        </form>
    </article>

    <article class="section-card product-list-card">
        <div class="list-header">
            <div>
                <p class="eyebrow">Historial</p>
                <h2>Ventas registradas</h2>
            </div>
            <span class="counter-pill"><?= count($ventas ?? []) ?> ventas</span>
        </div>

        <?php if (($ventas ?? collect())?->isEmpty()): ?>
            <div class="notice">Todavía no hay ventas registradas en la base de datos.</div>
        <?php else: ?>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cliente</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ventas as $venta): ?>
                            <tr>
                                <td><?= htmlspecialchars((string) $venta->product_name, ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars((string) $venta->customer_name, ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars((string) $venta->quantity, ENT_QUOTES, 'UTF-8') ?></td>
                                <td>$<?= htmlspecialchars(number_format((float) $venta->total, 2), ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars((string) $venta->created_at, ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </article>
</section>

<script>
    window.saleSyncPayload = <?= json_encode($saleSync ?? null, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
</script>
<script src="<?= htmlspecialchars(app_url('assets/js/ventas.js'), ENT_QUOTES, 'UTF-8') ?>"></script>
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Venta;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

final class VentaController
{
    public function index(): void
    {
        require_once dirname(__DIR__) . '/Config/database.php';
        $this->ensureSalesTable();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store();
            return;
        }

        $sales = Venta::query()->orderByDesc('created_at')->get();

        render('ventas/index', [
            'titulo' => 'Ventas',
            'descripcion' => 'Registrar ventas usando productos del inventario y persistencia con Eloquent ORM.',
            'ventas' => $sales,
            'flash' => flash_message(),
            'saleSync' => consume_sale_sync(),
        ]);
    }

    private function store(): void
    {
        if (!verify_csrf($_POST['csrf_token'] ?? null)) {
            flash_message('error', 'No se pudo validar la solicitud.');
            header('Location: ' . app_url('?ruta=ventas'));
            exit;
        }

        $productId = trim((string) ($_POST['product_id'] ?? ''));
        $productName = trim((string) ($_POST['product_name'] ?? ''));
        $customerName = trim((string) ($_POST['customer_name'] ?? ''));
        $quantity = (int) ($_POST['quantity'] ?? 0);
        $unitPrice = (float) ($_POST['unit_price'] ?? 0);
        $availableStock = (int) ($_POST['available_stock'] ?? -1);

        $errors = [];

        if ($productId === '') {
            $errors[] = 'Debe seleccionar un producto válido.';
        }

        if ($productName === '') {
            $errors[] = 'El producto es obligatorio.';
        }

        if ($customerName === '') {
            $errors[] = 'El nombre del cliente es obligatorio.';
        }

        if ($quantity < 1) {
            $errors[] = 'La cantidad debe ser mayor o igual a 1.';
        }

        if ($unitPrice <= 0) {
            $errors[] = 'El precio unitario debe ser mayor a 0.';
        }

        if ($availableStock < 0) {
            $errors[] = 'El stock disponible es inválido.';
        }

        if ($availableStock >= 0 && $quantity > $availableStock) {
            $errors[] = 'La cantidad no puede superar el stock disponible.';
        }

        if ($errors !== []) {
            flash_message('error', implode(' ', $errors));
            header('Location: ' . app_url('?ruta=ventas'));
            exit;
        }

        $sale = Venta::query()->create([
            'product_id' => $productId,
            'product_name' => $productName,
            'customer_name' => $customerName,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total' => round($quantity * $unitPrice, 2),
        ]);

        $_SESSION['sale_sync'] = [
            'product_id' => $sale->product_id,
            'quantity' => $sale->quantity,
        ];

        flash_message('success', 'Venta registrada correctamente.');
        header('Location: ' . app_url('?ruta=ventas'));
        exit;
    }

    private function ensureSalesTable(): void
    {
        $schema = Capsule::schema();

        if ($schema->hasTable('ventas')) {
            return;
        }

        $schema->create('ventas', function (Blueprint $table): void {
            $table->id();
            $table->string('product_id', 80);
            $table->string('product_name', 120);
            $table->string('customer_name', 120);
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }
}
<?php

declare(strict_types=1);

namespace App\Controllers;

final class ProductoController
{
    public function index(): void
    {
        render('productos/index', [
            'titulo' => 'Productos',
            'descripcion' => 'Modulo preparado para el CRUD de productos.',
        ]);
    }
}
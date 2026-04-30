<?php

declare(strict_types=1);

namespace App\Controllers;

final class VentaController
{
    public function index(): void
    {
        render('ventas/index', [
            'titulo' => 'Ventas',
            'descripcion' => 'Modulo preparado para registrar ventas con Eloquent ORM.',
        ]);
    }
}
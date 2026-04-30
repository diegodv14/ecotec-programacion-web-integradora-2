<?php

declare(strict_types=1);

namespace App\Controllers;

final class InicioController
{
    public function index(): void
    {
        render('inicio', [
            'titulo' => 'Inventario y ventas',
            'descripcion' => 'Sistema base con arquitectura MVC ligera, Docker y Eloquent ORM.',
        ]);
    }
}
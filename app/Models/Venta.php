<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Venta extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'product_id',
        'product_name',
        'customer_name',
        'quantity',
        'unit_price',
        'total',
    ];
}
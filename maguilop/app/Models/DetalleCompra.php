<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $table = 'detalle_compra'; // Adjust table name as needed
    protected $primaryKey = 'DetalleCompraID';
    public $timestamps = false;

    protected $fillable = [
        'CompraID',
        'ProductoID',
        'Cantidad',
        'PrecioUnitario',
        'Subtotal',
    ];

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'ProductoID', 'ProductoID');
    }
}
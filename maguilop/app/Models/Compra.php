<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compra'; // Nombre de la tabla
    protected $primaryKey = 'CompraID';
    public $timestamps = false;

    protected $fillable = [
        'ProveedorID',
        'EmpleadoID',
        'FechaCompra',
        'TotalCompra',
        'Estado',
    ];

    // Relación con DetalleCompra
    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class, 'CompraID');
    }

    // Método para calcular el total de los detalles
    public function calcularTotal()
    {
        return $this->detalles()->sum('Subtotal');
    }
}

// Modelo DetalleCompra definido dentro del mismo archivo
class DetalleCompra extends Model
{
    protected $table = 'detalle_compra'; // Nombre de la tabla
    protected $primaryKey = 'DetalleCompraID';
    public $timestamps = false;

    protected $fillable = [
        'CompraID',
        'ProductoID',
        'Cantidad',
        'PrecioUnitario',
        'Subtotal',
    ];

    // Relación con Compra
    public function compra()
    {
        return $this->belongsTo(Compra::class, 'CompraID');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PedidoDetalle;

class Pedido extends Model
{
    protected $table = 'pedido'; // Si tu tabla en la BD se llama 'pedido', está perfecto.
    protected $primaryKey = 'PedidoID';
    public $timestamps = false;

    protected $fillable = [
        'ClienteID',
        'EmpleadoID',
        'FechaPedido',
        'FechaEntrega',
        'Estado',
    ];

    public function detalles()
{
    return $this->hasMany(PedidoDetalle::class, 'PedidoID', 'PedidoID');
}

    public function cliente()
{
    return $this->belongsTo(Cliente::class, 'ClienteID', 'ClienteID');
}

public function empleado()
{
    return $this->belongsTo(Empleado::class, 'EmpleadoID', 'EmpleadoID');
}

public function producto()
{
    return $this->hasOneThrough(
        \App\Models\Producto::class,
        \App\Models\PedidoDetalle::class,
        'PedidoID',       // Foreign key en pedido_detalle
        'ProductoID',     // Foreign key en producto
        'PedidoID',       // Local key en pedido
        'ProductoID'      // Local key en pedido_detalle
    );
}



}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedido'; // Asegúrate de que la tabla se llame 'pedidos'
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
        return $this->hasMany(DetallePedido::class, 'PedidoID');
    }
}
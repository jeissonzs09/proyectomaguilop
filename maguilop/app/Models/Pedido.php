<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        // Agrega el tercer parámetro 'PedidoID' explícito para que quede claro la relación
  return $this->hasMany(DetallePedido::class, 'PedidoID');


    }
}
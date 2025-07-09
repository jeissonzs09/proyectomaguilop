<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'venta'; // Nombre de la tabla
    protected $primaryKey = 'VentaID'; // Clave primaria
    public $timestamps = false; // Desactivar timestamps si no se utilizan

    protected $fillable = [
        'ClienteID',
        'EmpleadoID',
        'ProductoID',
        'FechaVenta',
        'TotalVenta',
    ];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class, 'ClienteID');
    }

    // Relación con Empleado
    public function empleado()
    {
        return $this->belongsTo(\App\Models\Empleado::class, 'EmpleadoID');
    }

public function producto()
{
    return $this->belongsTo(\App\Models\Producto::class, 'ProductoID');
}

}

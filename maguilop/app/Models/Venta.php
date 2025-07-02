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
        'FechaVenta',
        'TotalVenta',
    ];
}
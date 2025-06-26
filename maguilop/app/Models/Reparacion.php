<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reparacion extends Model
{
    protected $table = 'reparacion';

    protected $primaryKey = 'ReparacionID';

    public $timestamps = false; 

    protected $fillable = [
        'ClienteID',
        'EmpleadoID',
        'ProductoID',
        'FechaEntrada',
        'FechaSalida',
        'DescripcionProblema',
        'Estado',
        'Costo',
    ];
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleado'; // Nombre de la tabla



    protected $primaryKey = 'EmpleadoID'; // Cambia a tu clave primaria

    public $timestamps = true; // Cambia a false si no usas timestamps

    protected $fillable = [
        'PersonaID',
        'Departamento',
        'Cargo',
        'FechaContratacion',
        'Salario',
    ];

    
}


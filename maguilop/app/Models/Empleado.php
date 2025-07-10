<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleado';
    protected $primaryKey = 'EmpleadoID';
    public $timestamps = true;

    protected $fillable = [
        'PersonaID',
        'Departamento',
        'Cargo',
        'FechaContratacion',
        'Salario',
    ];

   public function persona()
    {
        return $this->belongsTo(Persona::class, 'PersonaID', 'PersonaID');
    }

}
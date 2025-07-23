<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleado'; // o el nombre correcto de tu tabla

    protected $primaryKey = 'EmpleadoID';

    protected $fillable = [
        'PersonaID',
        'DepartamentoID',
        'Cargo',
        'FechaContratacion',
        'Salario',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'PersonaID', 'PersonaID');
    }


public function departamento()
{
    return $this->belongsTo(Departamento::class, 'DepartamentoID', 'DepartamentoID');
}


}
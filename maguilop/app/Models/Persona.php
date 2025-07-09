<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'persona';
    protected $primaryKey = 'PersonaID';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Apellido',
        'FechaNacimiento',
        'Genero',
        'CorreoElectronico',
    ];

    // Nombre completo (opcional)
    public function getNombreCompletoAttribute()
    {
        return "{$this->Nombre} {$this->Apellido}";
    }
}

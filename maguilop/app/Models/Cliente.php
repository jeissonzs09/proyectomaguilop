<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente'; // Singular
    protected $primaryKey = 'ClienteID';
    public $timestamps = false;

    protected $fillable = [
        'NombreCliente',
        'PersonaID',
        'Categoria',
        'FechaRegistro',
        'Estado',
        'Notas',
    ];
}

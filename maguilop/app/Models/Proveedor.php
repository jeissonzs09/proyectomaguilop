<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedor'; // O 'proveedores' si tu tabla está en plural

    protected $primaryKey = 'ProveedorID';

    public $timestamps = false; // Si tu tabla no usa created_at/updated_at

    protected $fillable = [
        'PersonaID',
        'EmpresaID',
        'RTN',
        'Descripcion',
        'URL_Website',
        'Ubicacion',
        'Telefono',
        'CorreoElectronico',
        'TipoProveedor',
        'FechaRegistro',
        'Estado',
        'Notas',
    ];
}


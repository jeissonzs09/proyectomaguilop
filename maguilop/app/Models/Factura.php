<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'factura';
    protected $primaryKey = 'FacturaID';
    public $timestamps = false;

    protected $fillable = [
        'ClienteID',
        'EmpleadoID',
        'Fecha',
        'Total',
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleFactura::class, 'FacturaID');
    }
}
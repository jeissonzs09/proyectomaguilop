<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    protected $table = 'backup'; // Singular
    protected $primaryKey = 'BackupID';
    public $timestamps = false;

    protected $fillable = [
        'UsuarioID',
        'FechaBackup',
        'NombreArchivo',
        'RutaArchivo',
        'TamanoMB',
        'Descripcion',
    ];
}
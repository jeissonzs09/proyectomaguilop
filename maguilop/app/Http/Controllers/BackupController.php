<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Backup;

class BackupController extends Controller
{
public function index()
{
    $backups = Backup::with('usuario')->orderByDesc('FechaBackup')->get();
    return view('backups.index', compact('backups'));
}

    public function generar(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:1000'
        ]);

        $user = Auth::user(); // el usuario autenticado
        $db     = config('database.connections.mysql.database');
        $userDB = config('database.connections.mysql.username');
        $passDB = config('database.connections.mysql.password');
        $host   = config('database.connections.mysql.host');

        $fecha = Carbon::now()->format('Y-m-d_H-i-s');
        $archivo = "backup_{$fecha}.sql";
        $carpeta = storage_path("app/backups");

        // Asegurar que la carpeta exista
        if (!File::exists($carpeta)) {
            File::makeDirectory($carpeta, 0755, true);
        }

        $rutaCompleta = "{$carpeta}/{$archivo}";

        // Generar backup con mysqldump
        $comando = "\"C:\\xampp\\mysql\\bin\\mysqldump.exe\" --user={$userDB} --password={$passDB} --host={$host} {$db} > \"{$rutaCompleta}\"";
        $resultado = null;
        $estado = null;
        exec($comando, $resultado, $estado);

        if ($estado !== 0) {
            return back()->with('error', 'No se pudo generar el backup. Verifica tus credenciales y configuración.');
        }

        // Obtener tamaño del archivo
        $tamanoBytes = File::size($rutaCompleta);
        $tamanoMB = number_format($tamanoBytes / 1048576, 2); // Convertir a MB

        // Ruta relativa
        $rutaRelativa = "backups/{$archivo}";

        // Insertar en la base de datos
        DB::table('backup')->insert([
            'UsuarioID' => $user->id,
            'FechaBackup' => Carbon::now(),
            'NombreArchivo' => $archivo,
            'RutaArchivo' => $rutaRelativa,
            'TamanoMB' => $tamanoMB,
            'Descripcion' => $request->descripcion
        ]);

        return redirect()->route('backup.index')->with('success', 'Backup generado exitosamente.');
    }

    public function eliminar($id)
{
    $backup = \App\Models\Backup::findOrFail($id);

    // Eliminar el archivo físico
    $ruta = storage_path('app/' . $backup->RutaArchivo);
    if (File::exists($ruta)) {
        File::delete($ruta);
    }

    // Eliminar de la base de datos
    $backup->delete();

    return redirect()->route('backup.index')->with('success', 'Backup eliminado correctamente.');
}
}

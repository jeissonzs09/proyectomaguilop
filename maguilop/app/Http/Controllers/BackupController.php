<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    public function index()
    {
        $backups = DB::table('backup')
            ->join('usuario', 'usuario.UsuarioID', '=', 'backup.UsuarioID')
            ->select('backup.*', 'usuario.NombreUsuario as usuario')
            ->orderByDesc('BackupID')
            ->get();

        return view('backups.index', compact('backups'));
    }

    public function store(Request $request)
{
    $descripcion = $request->input('descripcion');
    $fecha = now();
    $usuarioID = Auth::user()->UsuarioID;

    // Nombre y ruta del archivo
    $nombreArchivo = "backup_" . $fecha->format('Ymd_His') . ".sql";
    $ruta = storage_path("app/public/backups/$nombreArchivo"); // 🟢 Definida antes de usar

    // Crea la carpeta si no existe
    if (!file_exists(dirname($ruta))) {
        mkdir(dirname($ruta), 0755, true);
    }

    // Ejecutar mysqldump con ruta absoluta (Windows)
    $mysqldumpPath = 'C:\\xampp\\mysql\\bin\\mysqldump.exe'; // Cambia si tu path es distinto
    $comando = sprintf(
        '"%s" -u%s -p"%s" %s > "%s"',
        $mysqldumpPath,
        env('DB_USERNAME'),
        env('DB_PASSWORD'),
        env('DB_DATABASE'),
        $ruta
    );

    exec($comando . ' 2>&1', $output, $returnCode);

    if ($returnCode !== 0) {
        dd("Error al ejecutar mysqldump:", $output);
    }

    // Guardar en la base de datos
    DB::table('backup')->insert([
        'UsuarioID'     => $usuarioID,
        'FechaBackup'   => $fecha,
        'Descripcion'   => $descripcion,
        'NombreArchivo' => $nombreArchivo,
        'RutaArchivo'   => "storage/backups/$nombreArchivo", // ✅ visible por el navegador
        'TamanoMB'      => round(filesize($ruta) / 1048576, 2),
    ]);

    return redirect()->back()->with('success', 'Backup creado correctamente.');
}


    public function restore($id)
    {
        $backup = DB::table('backup')->where('BackupID', $id)->first();

        if (!$backup) {
            return back()->with('error', 'Backup no encontrado.');
        }

        $ruta = storage_path("app/public/backups/" . $backup->NombreArchivo);

        if (!file_exists($ruta)) {
            return back()->with('error', 'Archivo de respaldo no encontrado.');
        }

        $comando = sprintf(
            'mysql -u%s -p"%s" %s < "%s"',
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_DATABASE'),
            $ruta
        );

        exec($comando);

        return back()->with('success', 'Base de datos restaurada con éxito.');
    }
}


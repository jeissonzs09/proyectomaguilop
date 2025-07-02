<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Backup;
use App\Helpers\PermisosHelper;

class BackupController extends Controller
{
    public function index()
    {
        if (!PermisosHelper::tienePermiso('Backups', 'ver')) {
            abort(403, 'No tienes permiso para ver esta sección.');
        }

        $backups = Backup::all();
        return view('backups.index', compact('backups'));
    }

    public function create()
    {
        if (!PermisosHelper::tienePermiso('Backups', 'crear')) {
            abort(403);
        }

        return view('backups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'UsuarioID' => 'required|integer',
            'FechaBackup' => 'nullable|date',
            'NombreArchivo' => 'required|string|max:255',
            'RutaArchivo' => 'required|string',
            'TamanoMB' => 'nullable|numeric',
            'Descripcion' => 'nullable|string',
        ]);

        Backup::create($request->all());

        return redirect()->route('backups.index')->with('success', 'Backup registrado correctamente.');
    }

    public function edit($id)
    {
        if (!PermisosHelper::tienePermiso('Backups', 'editar')) {
            abort(403);
        }

        $backup = Backup::findOrFail($id);
        return view('backups.edit', compact('backup'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'UsuarioID' => 'required|integer',
            'FechaBackup' => 'nullable|date',
            'NombreArchivo' => 'required|string|max:255',
            'RutaArchivo' => 'required|string',
            'TamanoMB' => 'nullable|numeric',
            'Descripcion' => 'nullable|string',
        ]);

        $backup = Backup::findOrFail($id);
        $backup->update($request->all());

        return redirect()->route('backups.index')->with('success', 'Backup actualizado correctamente.');
    }

    public function destroy($id)
    {
        if (!PermisosHelper::tienePermiso('Backups', 'eliminar')) {
            abort(403);
        }

        Backup::findOrFail($id)->delete();

        return redirect()->route('backups.index')->with('success', 'Backup eliminado correctamente.');
    }
}
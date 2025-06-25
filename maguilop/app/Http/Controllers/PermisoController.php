<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermisoController extends Controller
{
    public function index()
    {
        $permisos = DB::table('permiso')->get();
        return view('permisos.index', compact('permisos'));
    }

    public function create()
    {
        return view('permisos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NombrePermiso' => 'required|max:255',
            'Descripcion' => 'nullable|string',
        ]);

        DB::table('permiso')->insert([
            'NombrePermiso' => $request->NombrePermiso,
            'Descripcion' => $request->Descripcion,
        ]);

        return redirect()->route('permisos.index')->with('success', 'Permiso creado correctamente.');
    }

    public function edit($id)
    {
        $permiso = DB::table('permiso')->where('PermisoID', $id)->first();
        return view('permisos.edit', compact('permiso'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NombrePermiso' => 'required|max:255',
            'Descripcion' => 'nullable|string',
        ]);

        DB::table('permiso')->where('PermisoID', $id)->update([
            'NombrePermiso' => $request->NombrePermiso,
            'Descripcion' => $request->Descripcion,
        ]);

        return redirect()->route('permisos.index')->with('success', 'Permiso actualizado correctamente.');
    }

    public function destroy($id)
    {
        DB::table('permiso')->where('PermisoID', $id)->delete();
        return redirect()->route('permisos.index')->with('success', 'Permiso eliminado correctamente.');
    }
}


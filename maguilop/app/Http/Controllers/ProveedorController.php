<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Helpers\PermisosHelper;

class ProveedorController extends Controller
{
    public function index()
    {
        if (!PermisosHelper::tienePermiso('Proveedores', 'ver')) {
            abort(403, 'No tienes permiso para ver esta sección.');
        }

        $proveedores = Proveedor::all();
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        if (!PermisosHelper::tienePermiso('Proveedores', 'crear')) {
            abort(403);
        }

        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'PersonaID' => 'required|integer|exists:persona,PersonaID',
            'EmpresaID' => 'nullable|integer',
            'RTN' => 'nullable|string|max:50',
            'Descripcion' => 'nullable|string',
            'URL_Website' => 'nullable|url|max:255',
            'Ubicacion' => 'nullable|string|max:255',
            'Telefono' => 'nullable|string|max:50',
            'CorreoElectronico' => 'nullable|email|max:255',
             'TipoProveedor' => 'required|in:Local,Internacional',
            'FechaRegistro' => 'required|date',
            'Estado' => 'required|in:Activo,Inactivo',
            'Notas' => 'nullable|string',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor registrado correctamente.');
    }

    public function edit($id)
    {
        if (!PermisosHelper::tienePermiso('Proveedores', 'editar')) {
            abort(403);
        }

        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'PersonaID' => 'required|integer|exists:persona,PersonaID',
            'EmpresaID' => 'nullable|integer',
            'RTN' => 'nullable|string|max:50',
            'Descripcion' => 'nullable|string',
            'URL_Website' => 'nullable|url|max:255',
            'Ubicacion' => 'nullable|string|max:255',
            'Telefono' => 'nullable|string|max:50',
            'CorreoElectronico' => 'nullable|email|max:255',
            'TipoProveedor' => 'required|in:Local,Internacional',
            'FechaRegistro' => 'required|date',
            'Estado' => 'required|in:Activo,Inactivo',
            'Notas' => 'nullable|string',
        ]);

        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy($id)
    {
        if (!PermisosHelper::tienePermiso('Proveedores', 'eliminar')) {
            abort(403);
        }

        Proveedor::findOrFail($id)->delete();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}

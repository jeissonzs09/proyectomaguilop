<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    public function index()
{
    $empresas = Empresa::all();
    return view('empresa.index', compact('empresas'));
}

    public function create()
{
    return view('empresa.create');
}

public function store(Request $request)
{
    $request->validate([
        'NombreEmpresa' => 'required|string|max:150',
        'Website' => 'nullable|string|max:150',
        'Telefono' => 'nullable|string|max:30',
        'Direccion' => 'nullable|string|max:255',
        'Descripcion' => 'nullable|string',
    ]);

    Empresa::create($request->only([
        'NombreEmpresa',
        'Website',
        'Telefono',
        'Direccion',
        'Descripcion',
    ]));

    return redirect()->route('empresa.index')->with('success', 'Empresa creada correctamente.');
}


public function edit($id)
{
    $empresa = Empresa::findOrFail($id);
    return view('empresa.edit', compact('empresa'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'NombreEmpresa' => 'required|string|max:150',
        'Website' => 'nullable|string|max:150',
        'Telefono' => 'nullable|string|max:30',
        'Direccion' => 'nullable|string|max:255',
        'Descripcion' => 'nullable|string',
    ]);

    $empresa = Empresa::findOrFail($id);

    $empresa->update($request->only([
        'NombreEmpresa',
        'Website',
        'Telefono',
        'Direccion',
        'Descripcion',
    ]));

    return redirect()->route('empresa.index')->with('success', 'Empresa actualizada correctamente.');
}

public function destroy($id)
{
    if (!\App\Helpers\PermisosHelper::tienePermiso('Empresas', 'eliminar')) {
        abort(403);
    }

    $empresa = Empresa::findOrFail($id);

    // Verificar si tiene proveedores asociados antes de eliminar
    if ($empresa->proveedores()->exists()) {
        return redirect()->route('empresa.index')
            ->with('error', 'No se puede eliminar la empresa porque tiene proveedores vinculados.');
    }

    // Si no tiene proveedores, ahora sí se puede eliminar
    $empresa->delete();

    return redirect()->route('empresa.index')->with('success', 'Empresa eliminada correctamente.');
}



}

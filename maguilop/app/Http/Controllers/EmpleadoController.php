<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Helpers\PermisosHelper;
 use App\Models\Persona;

class EmpleadoController extends Controller
{
    public function index()
    {
        if (!PermisosHelper::tienePermiso('Empleados', 'ver')) {
            abort(403, 'No tienes permiso para ver esta sección.');
        }

        $empleados = Empleado::with('persona')->get();

    return view('empleados.index', compact('empleados'));
    }

public function create()
{
    // Obtiene todas las personas
    $personas = Persona::all();

    // Pasa la colección a la vista
    return view('empleados.create', compact('personas'));
}



public function store(Request $request)
{
    $messages = [
        'PersonaID.unique' => 'La persona ya está registrada como empleado.',
    ];

    $data = $request->validate([
        'PersonaID'         => 'required|integer|exists:persona,PersonaID|unique:empleado,PersonaID',
        'Departamento'      => 'required|string|max:255',
        'Cargo'             => 'required|string|max:255',
        'FechaContratacion' => 'required|date',
        'Salario'           => 'required|numeric|min:0',
    ], $messages);

    Empleado::create($data);

    return redirect()
        ->route('empleados.index')
        ->with('success', 'Empleado registrado correctamente.');
}




    public function edit($id)
    {
        if (!PermisosHelper::tienePermiso('Empleados', 'editar')) {
            abort(403);
        }

        $empleado = Empleado::findOrFail($id);
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'PersonaID' => 'required|integer|exists:persona,PersonaID',
            'Departamento' => 'required|string|max:255',
            'Cargo' => 'required|string|max:255',
            'FechaContratacion' => 'required|date',
            'Salario' => 'required|numeric|min:0',
        ]);

        $empleado = Empleado::findOrFail($id);
        $empleado->update($request->all());

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }

public function destroy($id)
{
    try {
        $empleado = \App\Models\Empleado::findOrFail($id);
        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente.');
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect()->route('empleados.index')->with('error', 'No se puede eliminar el empleado porque tiene compras asociadas.');
    }
}

}
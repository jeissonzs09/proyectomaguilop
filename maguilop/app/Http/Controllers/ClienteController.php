<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Helpers\PermisosHelper;
use App\Models\Persona; 

class ClienteController extends Controller
{
    public function index()
    {
        if (!PermisosHelper::tienePermiso('Clientes', 'ver')) {
            abort(403, 'No tienes permiso para ver esta sección.');
        }

        $clientes = Cliente::with('persona')->get();
return view('clientes.index', compact('clientes'));

    }

    public function create()
    {
        if (!PermisosHelper::tienePermiso('Clientes', 'crear')) {
            abort(403);
        }

        $personas = Persona::all();
        return view('clientes.create', compact('personas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'NombreCliente' => 'required|string|max:255',
            'PersonaID' => 'required|integer|exists:persona,PersonaID',
            'Categoria' => 'nullable|string|max:100',
            'FechaRegistro' => 'required|date',
            'Estado' => 'required|in:Activo,Inactivo',
            'Notas' => 'nullable|string',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente registrado correctamente.');
    }

    public function edit($id)
    {
        if (!PermisosHelper::tienePermiso('Clientes', 'editar')) {
            abort(403);
        }

        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NombreCliente' => 'required|string|max:255',
            'PersonaID' => 'required|integer|exists:persona,PersonaID',
            'Categoria' => 'nullable|string|max:100',
            'FechaRegistro' => 'required|date',
            'Estado' => 'required|in:Activo,Inactivo',
            'Notas' => 'nullable|string',
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

public function destroy($id)
{
    try {
        $cliente = \App\Models\Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect()->route('clientes.index')->with('error', 'No se puede eliminar el cliente porque tiene pedidos asociados.');
    }
}

}

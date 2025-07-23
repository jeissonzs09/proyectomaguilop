<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Persona;
use App\Helpers\PermisosHelper;
use Barryvdh\DomPDF\Facade\Pdf;

class ClienteController extends Controller
{
public function index(Request $request)
{
    if (!PermisosHelper::tienePermiso('Clientes', 'ver')) {
        abort(403, 'No tienes permiso para ver esta sección.');
    }

    $query = Cliente::with('persona');

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function($q) use ($search) {
            $q->where('NombreCliente', 'LIKE', "%{$search}%")
              ->orWhere('Categoria', 'LIKE', "%{$search}%")
              ->orWhere('Estado', 'LIKE', "%{$search}%")
              ->orWhereHas('persona', function($q2) use ($search) {
                  $q2->where('Nombre', 'LIKE', "%{$search}%")
                     ->orWhere('Apellido', 'LIKE', "%{$search}%");
              });
        });
    }

    $clientes = $query->paginate(5);

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
            'NombreCliente' => 'required|string|max:100',
            'PersonaID' => 'required|exists:persona,PersonaID',
            'Categoria' => 'nullable|in:Regular,Premium,VIP',
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

        $cliente = Cliente::with('persona')->findOrFail($id);
        $personas = Persona::all();
        return view('clientes.edit', compact('cliente', 'personas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NombreCliente' => 'required|string|max:100',
            'PersonaID' => 'required|exists:persona,PersonaID',
            'Categoria' => 'nullable|in:Regular,Premium,VIP',
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
        if (!PermisosHelper::tienePermiso('Clientes', 'eliminar')) {
            abort(403);
        }

        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->delete();
            return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('clientes.index')->with('error', 'No se puede eliminar el cliente: ' . $e->getMessage());
        }
    }

    public function exportarPDF(Request $request)
{
    $query = Cliente::with('persona');

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function($q) use ($search) {
            $q->where('NombreCliente', 'LIKE', "%{$search}%")
              ->orWhere('Categoria', 'LIKE', "%{$search}%")
              ->orWhere('Estado', 'LIKE', "%{$search}%")
              ->orWhereHas('persona', function($q2) use ($search) {
                  $q2->where('Nombre', 'LIKE', "%{$search}%")
                     ->orWhere('Apellido', 'LIKE', "%{$search}%");
              });
        });
    }

    $clientes = $query->get();

    $pdf = Pdf::loadView('clientes.pdf', compact('clientes'))->setPaper('a4', 'landscape');
    return $pdf->download('clientes.pdf');
}
}

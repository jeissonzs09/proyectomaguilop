<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Helpers\PermisosHelper;

class CompraController extends Controller
{
    // Método para mostrar la lista de compras
    public function index()
    {
        if (!PermisosHelper::tienePermiso('Compras', 'ver')) {
            abort(403, 'No tienes permiso para ver esta sección.');
        }

        $compras = Compra::all(); // Obtener todas las compras
        return view('compras.index', compact('compras'));
    }

    // Método para mostrar el formulario de creación de una nueva compra
    public function create()
    {
        if (!PermisosHelper::tienePermiso('Compras', 'crear')) {
            abort(403);
        }

        return view('compras.create'); // Vista para crear una nueva compra
    }

    // Método para almacenar una nueva compra
    public function store(Request $request)
    {
        $request->validate([
            'ProveedorID' => 'required|integer|exists:proveedor,ProveedorID',
            'EmpleadoID' => 'required|integer|exists:empleado,EmpleadoID',
            'FechaCompra' => 'required|date',
            'TotalCompra' => 'required|numeric',
            'Estado' => 'required|in:Recibido,Pendiente,Cancelado',
        ]);

        Compra::create($request->all()); // Crear la compra

        return redirect()->route('compras.index')->with('success', 'Compra registrada correctamente.');
    }

    // Método para mostrar el formulario de edición de una compra
    public function edit($id)
    {
        if (!PermisosHelper::tienePermiso('Compras', 'editar')) {
            abort(403);
        }

        $compra = Compra::findOrFail($id); // Obtener la compra por ID
        return view('compras.edit', compact('compra')); // Vista para editar la compra
    }

    // Método para actualizar una compra existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'ProveedorID' => 'required|integer|exists:proveedor,ProveedorID',
            'EmpleadoID' => 'required|integer|exists:empleado,EmpleadoID',
            'FechaCompra' => 'required|date',
            'TotalCompra' => 'required|numeric',
            'Estado' => 'required|in:Recibido,Pendiente,Cancelado',
        ]);

        $compra = Compra::findOrFail($id); // Obtener la compra por ID
        $compra->update($request->all()); // Actualizar la compra

        return redirect()->route('compras.index')->with('success', 'Compra actualizada correctamente.');
    }

    // Método para eliminar una compra
    public function destroy($id)
    {
        if (!PermisosHelper::tienePermiso('Compras', 'eliminar')) {
            abort(403);
        }

        Compra::findOrFail($id)->delete(); // Eliminar la compra

        return redirect()->route('compras.index')->with('success', 'Compra eliminada correctamente.');
    }
}
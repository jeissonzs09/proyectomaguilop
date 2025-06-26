<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Helpers\PermisosHelper;

class ProductoController extends Controller
{
    public function index()
    {
        if (!PermisosHelper::tienePermiso('Productos', 'ver')) {
        abort(403, 'No tienes permiso para ver esta sección.');
    }
        $productos = Producto::paginate(10);
        return view('producto.index', compact('productos'));
    }

    public function create()
    {
        return view('producto.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NombreProducto' => 'required|string|max:150',
            'Descripcion' => 'nullable|string',
            // Validar otros campos numéricos como precio, stock, IDs
        ]);

        Producto::create($request->all());

        return redirect()->route('producto.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('producto.edit', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NombreProducto' => 'required|string|max:150',
            'Descripcion' => 'nullable|string',
            // Validar otros campos
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($request->all());

        return redirect()->route('producto.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('producto.index')->with('success', 'Producto eliminado correctamente.');
    }
}


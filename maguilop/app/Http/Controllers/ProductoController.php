<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Helpers\PermisosHelper;
use App\Models\Proveedor; // ✅ Correcto
use Barryvdh\DomPDF\Facade\Pdf;

class ProductoController extends Controller
{
    public function index(Request $request)
{
    if (!PermisosHelper::tienePermiso('Productos', 'ver')) {
        abort(403, 'No tienes permiso para ver esta sección.');
    }

    $query = Producto::with('proveedor');

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('NombreProducto', 'LIKE', "%{$search}%")
              ->orWhere('Descripcion', 'LIKE', "%{$search}%")
              ->orWhere('PrecioCompra', 'LIKE', "%{$search}%")
              ->orWhere('PrecioVenta', 'LIKE', "%{$search}%")
              ->orWhere('Stock', 'LIKE', "%{$search}%")
              ->orWhereHas('proveedor', fn($q) => $q->where('ProveedorID', 'LIKE', "%{$search}%"));
    }

    $productos = $query->paginate(5);
    return view('producto.index', compact('productos'));
}


    public function create()
    {
    $proveedores = Proveedor::all();
    return view('producto.create', compact('proveedores'));
    }

    public function store(Request $request)
{
    $request->validate([
        'NombreProducto' => 'required|string|max:150',
        'Descripcion' => 'nullable|string|max:500',
        'PrecioCompra' => 'required|numeric|min:0',
        'PrecioVenta' => 'required|numeric|min:0',
        'Stock' => 'required|integer|min:0',
        'ProveedorID' => 'required|integer|exists:proveedor,ProveedorID',
    ]);

    Producto::create($request->only([
        'NombreProducto',
        'Descripcion',
        'PrecioCompra',
        'PrecioVenta',
        'Stock',
        'ProveedorID',
    ]));

    return redirect()->route('producto.index')->with('success', 'Producto creado correctamente.');
}


    public function edit($id)
{
    $producto = Producto::findOrFail($id);
    $proveedores = Proveedor::all();

    return view('producto.edit', compact('producto', 'proveedores'));
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

public function exportarPDF(Request $request)
{
    $query = Producto::with('proveedor');

    if ($request->filled('search')) {
    $search = $request->search;
    
    $query->where('NombreProducto', 'LIKE', "%{$search}%")
          ->orWhere('Descripcion', 'LIKE', "%{$search}%")
          ->orWhere('PrecioCompra', 'LIKE', "%{$search}%")
          ->orWhere('PrecioVenta', 'LIKE', "%{$search}%")
          ->orWhere('Stock', 'LIKE', "%{$search}%")
          ->orWhereHas('proveedor', fn($q) => 
              $q->where('Descripcion', 'LIKE', "%{$search}%") // Cambiado aquí
          );
}

$productos = $query->get();

    $pdf = Pdf::loadView('producto.pdf', compact('productos'))
              ->setPaper('a4', 'landscape');

    return $pdf->download('productos.pdf');
}

}


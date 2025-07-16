<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\PermisosHelper;


class VentaController extends Controller
{
public function index(Request $request)
{
    if (!PermisosHelper::tienePermiso('Ventas', 'ver')) {
        abort(403, 'No tienes permiso para ver esta sección.');
    }

    $query = Venta::with(['cliente', 'empleado.persona', 'producto']);

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where('FechaVenta', 'LIKE', "%{$search}%")
              ->orWhere('TotalVenta', 'LIKE', "%{$search}%")
              ->orWhereHas('cliente', fn($q) =>
                  $q->where('NombreCliente', 'LIKE', "%{$search}%")
              )
              ->orWhereHas('empleado.persona', fn($q) =>
                  $q->where('Nombre', 'LIKE', "%{$search}%")
                    ->orWhere('Apellido', 'LIKE', "%{$search}%")
              )
              ->orWhereHas('producto', fn($q) =>
                  $q->where('NombreProducto', 'LIKE', "%{$search}%")
              );
    }

    $ventas = $query->paginate(5);
    return view('ventas.index', compact('ventas'));
}


public function create()
{
$clientes = Cliente::all();
$empleados = Empleado::all();
$productos = Producto::all(); // esto es clave
return view('ventas.create', compact('clientes', 'empleados', 'productos'));
}

    public function store(Request $request)
    {
$request->validate([
    'ClienteID' => 'required|integer|exists:cliente,ClienteID',
    'EmpleadoID' => 'required|integer|exists:empleado,EmpleadoID',
    'ProductoID' => 'required|integer|exists:producto,ProductoID', // <-- agregar esta línea
    'FechaVenta' => 'required|date',
    'TotalVenta' => 'required|numeric',
]);


        Venta::create($request->all());

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
    }

public function edit($id)
{
    $venta = Venta::findOrFail($id);
    $clientes = Cliente::all();
    $empleados = Empleado::all();
    $productos = Producto::all();

    return view('ventas.edit', compact('venta', 'clientes', 'empleados', 'productos'));
}



    public function update(Request $request, $id)
    {
$request->validate([
    'ClienteID' => 'required|integer|exists:cliente,ClienteID',
    'EmpleadoID' => 'required|integer|exists:empleado,EmpleadoID',
    'ProductoID' => 'required|integer|exists:producto,ProductoID', // <-- también aquí
    'FechaVenta' => 'required|date',
    'TotalVenta' => 'required|numeric',
]);


        $venta = Venta::findOrFail($id);
        $venta->update($request->all());

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy($id)
{
    $venta = \App\Models\Venta::findOrFail($id);
    $venta->delete();

    return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente.');
}


public function exportarPDF(Request $request)
{
    $query = Venta::with(['cliente', 'empleado.persona', 'producto'])->get();

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where('FechaVenta', 'LIKE', "%{$search}%")
              ->orWhere('TotalVenta', 'LIKE', "%{$search}%")
              ->orWhereHas('cliente', fn($q) => $q->where('NombreCliente', 'LIKE', "%{$search}%"))
              ->orWhereHas('empleado.persona', fn($q) =>
                  $q->where('Nombre', 'LIKE', "%{$search}%")
                    ->orWhere('Apellido', 'LIKE', "%{$search}%")
              )
              ->orWhereHas('producto', fn($q) => $q->where('NombreProducto', 'LIKE', "%{$search}%"));
    }

    $ventas = $query->get();

    $pdf = Pdf::loadView('ventas.pdf', compact('ventas'))->setPaper('a4', 'landscape');
    return $pdf->download('ventas.pdf');
}




}
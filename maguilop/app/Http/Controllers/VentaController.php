<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Producto;


class VentaController extends Controller
{
public function index()
{
    $ventas = Venta::with(['cliente', 'empleado.persona', 'producto'])->get();
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

}
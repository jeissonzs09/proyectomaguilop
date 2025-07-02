<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::all();
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        return view('ventas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ClienteID' => 'required|integer|exists:cliente,ClienteID',
            'EmpleadoID' => 'required|integer|exists:empleado,EmpleadoID',
            'FechaVenta' => 'required|date',
            'TotalVenta' => 'required|numeric',
        ]);

        Venta::create($request->all());

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
    }

    public function edit($id)
    {
        $venta = Venta::findOrFail($id);
        return view('ventas.edit', compact('venta'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ClienteID' => 'required|integer|exists:cliente,ClienteID',
            'EmpleadoID' => 'required|integer|exists:empleado,EmpleadoID',
            'FechaVenta' => 'required|date',
            'TotalVenta' => 'required|numeric',
        ]);

        $venta = Venta::findOrFail($id);
        $venta->update($request->all());

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente.');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Helpers\PermisosHelper;

class FacturaController extends Controller
{
    public function index()
    {
        if (!PermisosHelper::tienePermiso('Factura', 'ver')) {
            abort(403, 'No tienes permiso para ver esta sección.');
        }

        $facturas = Factura::with('detalles')->get(); // Cargar detalles relacionados
        return view('facturas.index', compact('facturas'));
    }

    public function create()
    {
        if (!PermisosHelper::tienePermiso('Factura', 'crear')) {
            abort(403);
        }

        return view('facturas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ClienteID' => 'required|integer',
            'EmpleadoID' => 'required|integer',
            'Fecha' => 'required|date',
            'Total' => 'required|numeric',
            'detalles' => 'required|array|min:1',
            'detalles.*.ProductoID' => 'required|integer',
            'detalles.*.Cantidad' => 'required|integer|min:1',
            'detalles.*.PrecioUnitario' => 'required|numeric|min:0',
            'detalles.*.Subtotal' => 'required|numeric|min:0',
        ]);

        $factura = Factura::create([
            'ClienteID' => $request->ClienteID,
            'EmpleadoID' => $request->EmpleadoID,
            'Fecha' => $request->Fecha,
            'Total' => $request->Total,
        ]);

        foreach ($request->detalles as $detalle) {
            DetalleFactura::create([
                'FacturaID' => $factura->FacturaID,
                'ProductoID' => $detalle['ProductoID'],
                'Cantidad' => $detalle['Cantidad'],
                'PrecioUnitario' => $detalle['PrecioUnitario'],
                'Subtotal' => $detalle['Subtotal'],
            ]);
        }

        return redirect()->route('facturas.index')->with('success', 'Factura registrada correctamente.');
    }

    public function edit($id)
    {
        if (!PermisosHelper::tienePermiso('Factura', 'editar')) {
            abort(403);
        }

        $factura = Factura::with('detalles')->findOrFail($id);
        return view('facturas.edit', compact('factura'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ClienteID' => 'required|integer',
            'EmpleadoID' => 'required|integer',
            'Fecha' => 'required|date',
            'Total' => 'required|numeric',
            'detalles' => 'required|array|min:1',
            'detalles.*.ProductoID' => 'required|integer',
            'detalles.*.Cantidad' => 'required|integer|min:1',
            'detalles.*.PrecioUnitario' => 'required|numeric|min:0',
            'detalles.*.Subtotal' => 'required|numeric|min:0',
        ]);

        $factura = Factura::findOrFail($id);
        $factura->update([
            'ClienteID' => $request->ClienteID,
            'EmpleadoID' => $request->EmpleadoID,
            'Fecha' => $request->Fecha,
            'Total' => $request->Total,
        ]);

        // Primero eliminar detalles antiguos
        DetalleFactura::where('FacturaID', $id)->delete();

        // Insertar los nuevos detalles
        foreach ($request->detalles as $detalle) {
            DetalleFactura::create([
                'FacturaID' => $factura->FacturaID,
                'ProductoID' => $detalle['ProductoID'],
                'Cantidad' => $detalle['Cantidad'],
                'PrecioUnitario' => $detalle['PrecioUnitario'],
                'Subtotal' => $detalle['Subtotal'],
            ]);
        }

        return redirect()->route('facturas.index')->with('success', 'Factura actualizada correctamente.');
    }

    public function destroy($id)
    {
        if (!PermisosHelper::tienePermiso('Factura', 'eliminar')) {
            abort(403);
        }

        // Primero elimina los detalles relacionados
        DetalleFactura::where('FacturaID', $id)->delete();

        // Luego elimina la factura
        Factura::findOrFail($id)->delete();

        return redirect()->route('facturas.index')->with('success', 'Factura eliminada correctamente.');
    }
}
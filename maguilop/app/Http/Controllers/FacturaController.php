<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Helpers\PermisosHelper;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf;

class FacturaController extends Controller
{
public function index(Request $request)
{
    if (!PermisosHelper::tienePermiso('Factura', 'ver')) {
        abort(403, 'No tienes permiso para ver esta sección.');
    }

    $query = Factura::with(['cliente', 'empleado.persona', 'producto', 'detalles']);

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where('Fecha', 'LIKE', "%{$search}%")
              ->orWhere('Total', 'LIKE', "%{$search}%")
              ->orWhereHas('cliente', fn($q) =>
                  $q->where('NombreCliente', 'LIKE', "%{$search}%")
              )
              ->orWhereHas('empleado.persona', fn($q) =>
                  $q->where('Nombre', 'LIKE', "%{$search}%")
                    ->orWhere('Apellido', 'LIKE', "%{$search}%")
              )
              ->orWhereHas('detalles.producto', fn($q) =>
    $q->where('NombreProducto', 'LIKE', "%{$search}%")
)
              ->orWhereHas('detalles', fn($q) =>
                  $q->where('Cantidad', 'LIKE', "%{$search}%")
                    ->orWhere('PrecioUnitario', 'LIKE', "%{$search}%")
                    ->orWhere('Subtotal', 'LIKE', "%{$search}%")
              );
    }

    $facturas = $query->paginate(5);
    return view('facturas.index', compact('facturas'));
}


    public function create()
{
    $clientes = Cliente::all();
    $empleados = Empleado::with('persona')->get();
    $productos = Producto::all();

    return view('facturas.create', compact('clientes', 'empleados', 'productos'));
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
    $factura = Factura::findOrFail($id);
    $clientes = Cliente::all();
    $empleados = Empleado::with('persona')->get();
    $productos = Producto::all();

    return view('facturas.edit', compact('factura', 'clientes', 'empleados', 'productos'));
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


public function exportarPDF(Request $request)
{
    $query = Factura::with(['cliente', 'empleado.persona', 'producto', 'detalles.producto']);

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where('Fecha', 'LIKE', "%{$search}%")
              ->orWhere('Total', 'LIKE', "%{$search}%")
              ->orWhereHas('cliente', fn($q) =>
                  $q->where('NombreCliente', 'LIKE', "%{$search}%")
              )
              ->orWhereHas('empleado.persona', fn($q) =>
                  $q->where('Nombre', 'LIKE', "%{$search}%")
                    ->orWhere('Apellido', 'LIKE', "%{$search}%")
              )
              ->orWhereHas('detalles.producto', fn($q) =>
    $q->where('NombreProducto', 'LIKE', "%{$search}%")
)
              ->orWhereHas('detalles', fn($q) =>
                  $q->where('Cantidad', 'LIKE', "%{$search}%")
                    ->orWhere('PrecioUnitario', 'LIKE', "%{$search}%")
                    ->orWhere('Subtotal', 'LIKE', "%{$search}%")
              );
    }

    $facturas = $query->get();

    $pdf = Pdf::loadView('facturas.pdf', compact('facturas'))->setPaper('a4', 'landscape');
    return $pdf->download('facturas.pdf');
}

}
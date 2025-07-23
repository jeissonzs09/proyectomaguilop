<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Proveedor;
use App\Models\Empleado;
use App\Models\Producto;
use App\Helpers\PermisosHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index(Request $request)
    {
        if (!PermisosHelper::tienePermiso('Compra', 'ver')) {
            abort(403, 'No tienes permiso para ver esta sección.');
        }

        $query = Compra::with(['proveedor', 'empleado.persona', 'detalles.producto']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                $q->where('FechaCompra', 'LIKE', "%{$search}%")
                  ->orWhere('TotalCompra', 'LIKE', "%{$search}%")
                  ->orWhereHas('proveedor', fn($q2) =>
                      $q2->where('Descripcion', 'LIKE', "%{$search}%")
                  )
                  ->orWhereHas('empleado.persona', fn($q2) =>
                      $q2->where('Nombre', 'LIKE', "%{$search}%")
                         ->orWhere('Apellido', 'LIKE', "%{$search}%")
                  )
                  ->orWhereHas('detalles.producto', fn($q2) =>
                      $q2->where('NombreProducto', 'LIKE', "%{$search}%")
                  )
                  ->orWhereHas('detalles', fn($q2) =>
                      $q2->where('Cantidad', 'LIKE', "%{$search}%")
                         ->orWhere('PrecioUnitario', 'LIKE', "%{$search}%")
                         ->orWhere('Subtotal', 'LIKE', "%{$search}%")
                  );
            });
        }

        $compras = $query->paginate(5);
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        if (!PermisosHelper::tienePermiso('Compra', 'crear')) {
            abort(403);
        }

        $proveedores = Proveedor::all();
        $empleados = Empleado::with('persona')->get();

        return view('compras.create', compact('proveedores', 'empleados'));
    }

    public function store(Request $request)
{
    $request->validate([
        'ProveedorID' => 'required|integer',
        'EmpleadoID' => 'required|integer',
        'FechaCompra' => 'required|date',
        'TotalCompra' => 'required|numeric',
        'Estado' => 'required|string',
    ]);

    // Limpiar el valor del total para asegurar que se guarda como número válido
    $totalCompra = str_replace(',', '.', $request->TotalCompra);
    $totalCompra = floatval(preg_replace('/[^0-9.]/', '', $totalCompra));

    Compra::create([
        'ProveedorID' => $request->ProveedorID,
        'EmpleadoID' => $request->EmpleadoID,
        'FechaCompra' => $request->FechaCompra,
        'TotalCompra' => $totalCompra,
        'Estado' => $request->Estado,
    ]);

    return redirect()->route('compras.index')->with('success', 'Compra registrada correctamente.');
}

    public function edit($id)
    {
        if (!PermisosHelper::tienePermiso('Compra', 'editar')) {
            abort(403);
        }

        $compra = Compra::with(['detalles'])->findOrFail($id);
        $proveedores = Proveedor::all();
        $empleados = Empleado::with('persona')->get();
        $productos = Producto::all();

        return view('compras.edit', compact('compra', 'proveedores', 'empleados', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ProveedorID' => 'required|integer',
            'EmpleadoID' => 'required|integer',
            'FechaCompra' => 'required|date',
            'TotalCompra' => 'required|numeric|min:0',
            'Estado' => 'required|string',
        ]);

        $compra = Compra::findOrFail($id);
        $totalCompra = str_replace(',', '.', $request->TotalCompra);

        if (!is_numeric($totalCompra) || $totalCompra < 0) {
            return redirect()->back()->withErrors(['TotalCompra' => 'El total de la compra debe ser un número válido y mayor o igual a cero.']);
        }

        $totalCompra = str_replace(',', '.', $request->TotalCompra);
$totalCompra = floatval(preg_replace('/[^0-9.]/', '', $totalCompra));

$compra->TotalCompra = $totalCompra;


        $compra->update([
            'ProveedorID' => $request->ProveedorID,
            'EmpleadoID' => $request->EmpleadoID,
            'FechaCompra' => $request->FechaCompra,
            'TotalCompra' => $totalCompra,
            'Estado' => $request->Estado,
        ]);

        return redirect()->route('compras.index')->with('success', 'Compra actualizada correctamente.');
    }

    public function destroy($id)
    {
        if (!PermisosHelper::tienePermiso('Compra', 'eliminar')) {
            abort(403);
        }

        DB::beginTransaction();

        try {
            DetalleCompra::where('CompraID', $id)->delete();
            Compra::findOrFail($id)->delete();

            DB::commit();
            return redirect()->route('compras.index')->with('success', 'Compra eliminada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('compras.index')->withErrors('Error al eliminar la compra: ' . $e->getMessage());
        }
    }

    public function exportarPDF(Request $request)
    {
        $query = Compra::with(['proveedor', 'empleado.persona', 'detalles.producto']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                $q->where('FechaCompra', 'LIKE', "%{$search}%")
                  ->orWhere('TotalCompra', 'LIKE', "%{$search}%")
                  ->orWhereHas('proveedor', fn($q2) =>
                      $q2->where('Descripcion', 'LIKE', "%{$search}%")
                  )
                  ->orWhereHas('empleado.persona', fn($q2) =>
                      $q2->where('Nombre', 'LIKE', "%{$search}%")
                         ->orWhere('Apellido', 'LIKE', "%{$search}%")
                  )
                  ->orWhereHas('detalles.producto', fn($q2) =>
                      $q2->where('NombreProducto', 'LIKE', "%{$search}%")
                  )
                  ->orWhereHas('detalles', fn($q2) =>
                      $q2->where('Cantidad', 'LIKE', "%{$search}%")
                         ->orWhere('PrecioUnitario', 'LIKE', "%{$search}%")
                         ->orWhere('Subtotal', 'LIKE', "%{$search}%")
                  );
            });
        }

        $compras = $query->get();

        $pdf = Pdf::loadView('compras.pdf', compact('compras'))->setPaper('a4', 'landscape');
        return $pdf->download('compras.pdf');
    }
}
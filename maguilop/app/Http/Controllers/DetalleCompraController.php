<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetalleCompra; // Make sure to create this model
use App\Helpers\PermisosHelper;

class DetalleCompraController extends Controller
{
    public function index()
    {
        if (!PermisosHelper::tienePermiso('DetalleCompras', 'ver')) {
            abort(403, 'No tienes permiso para ver esta sección.');
        }

        $detalleCompras = DetalleCompra::all();
        return view('detallecompras.index', compact('detalleCompras'));
    }

    public function create()
    {
        if (!PermisosHelper::tienePermiso('DetalleCompras', 'crear')) {
            abort(403);
        }

        return view('detallecompras.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'CompraID' => 'required|integer|exists:compra,CompraID',
            'ProductoID' => 'required|integer|exists:producto,ProductoID',
            'Cantidad' => 'required|integer|min:1',
            'PrecioUnitario' => 'nullable|numeric|between:0,999999.99',
            'Subtotal' => 'nullable|numeric|between:0,999999.99',
        ]);

        DetalleCompra::create($request->all());

        return redirect()->route('detallecompras.index')->with('success', 'Detalle de compra registrado correctamente.');
    }

    public function edit($id)
{
    if (!PermisosHelper::tienePermiso('DetalleCompras', 'editar')) {
        abort(403);
    }

    $detalle = DetalleCompra::findOrFail($id);
    return view('detallecompras.edit', compact('detalle'));
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'CompraID' => 'required|integer|exists:compra,CompraID',
            'ProductoID' => 'required|integer|exists:producto,ProductoID',
            'Cantidad' => 'required|integer|min:1',
            'PrecioUnitario' => 'nullable|numeric|between:0,999999.99',
            'Subtotal' => 'nullable|numeric|between:0,999999.99',
        ]);

        $detalleCompra = DetalleCompra::findOrFail($id);
        $detalleCompra->update($request->all());

        return redirect()->route('detallecompras.index')->with('success', 'Detalle de compra actualizado correctamente.');
    }

    public function destroy($id)
    {
        if (!PermisosHelper::tienePermiso('DetalleCompras', 'eliminar')) {
            abort(403);
        }

        DetalleCompra::findOrFail($id)->delete();

        return redirect()->route('detallecompras.index')->with('success', 'Detalle de compra eliminado correctamente.');
    }
}
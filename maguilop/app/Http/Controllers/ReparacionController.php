<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reparacion;
use App\Helpers\PermisosHelper;
use App\Models\Cliente; // ✅ Correcto
use App\Models\Producto;


class ReparacionController extends Controller
{

public function index(Request $request)
{
    if (!PermisosHelper::tienePermiso('Reparaciones', 'ver')) {
        abort(403, 'No tienes permiso para ver esta sección.');
    }

    // ⚠️ importante: el paginado se hace sobre el modelo Reparacion
    $query = Reparacion::query()
        ->join('cliente', 'reparacion.ClienteID', '=', 'cliente.ClienteID')
        ->join('producto', 'reparacion.ProductoID', '=', 'producto.ProductoID')
        ->select('reparacion.*'); // evita conflictos por columnas repetidas

    if ($request->has('search')) {
        $search = $request->search;

        $query->whereRaw("
    CONCAT_WS(' ',
        ReparacionID,
        cliente.NombreCliente,
        producto.NombreProducto,
        FechaEntrada,
        FechaSalida,
        reparacion.Estado,
        DescripcionProblema,
        Costo
    ) LIKE ?", ["%{$search}%"]);
    }

    $reparaciones = $query->with(['cliente', 'producto'])->paginate(5);

    return view('reparaciones.index', compact('reparaciones'));
}



    public function create()
    {
            if (!PermisosHelper::tienePermiso('Reparaciones', 'crear')) {
        abort(403);
    }
    $clientes = Cliente::all();
    $productos = Producto::all();

    return view('reparaciones.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ClienteID' => 'required|integer',
            'ProductoID' => 'required|integer',
            'FechaEntrada' => 'required|date',
            'FechaSalida' => 'nullable|date|after_or_equal:FechaEntrada',
            'DescripcionProblema' => 'nullable|string',
            'Estado' => 'required|in:Pendiente,En proceso,Finalizado',
            'Costo' => 'required|numeric|min:0',
        ]);

        Reparacion::create($request->all());

        return redirect()->route('reparaciones.index')->with('success', 'Reparación registrada correctamente.');
    }

    public function edit($id)
    {
            if (!PermisosHelper::tienePermiso('Reparaciones', 'editar')) {
        abort(403);
    }
    $reparacion = Reparacion::findOrFail($id);
    $clientes = Cliente::all();
    $productos = Producto::all();

    return view('reparaciones.edit', compact('reparacion', 'clientes', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ClienteID' => 'required|integer',
            'ProductoID' => 'required|integer',
            'FechaEntrada' => 'required|date',
            'FechaSalida' => 'nullable|date|after_or_equal:FechaEntrada',
            'DescripcionProblema' => 'nullable|string',
            'Estado' => 'required|in:Pendiente,En proceso,Finalizado',
            'Costo' => 'required|numeric|min:0',
        ]);

        $reparacion = Reparacion::findOrFail($id);
        $reparacion->update($request->all());

        return redirect()->route('reparaciones.index')->with('success', 'Reparación actualizada correctamente.');
    }

    public function destroy($id)
    {
            if (!PermisosHelper::tienePermiso('Reparaciones', 'eliminar')) {
        abort(403);
    }
        Reparacion::findOrFail($id)->delete();
        return redirect()->route('reparaciones.index')->with('success', 'Reparación eliminada correctamente.');
    }
}

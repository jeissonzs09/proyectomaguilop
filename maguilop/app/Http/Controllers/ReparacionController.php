<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reparacion;
use App\Helpers\PermisosHelper;

class ReparacionController extends Controller
{
    public function index()
    {
        if (!PermisosHelper::tienePermiso('Reparaciones', 'ver')) {
        abort(403, 'No tienes permiso para ver esta sección.');
    }
        $reparaciones = Reparacion::all();
        return view('reparaciones.index', compact('reparaciones'));
    }

    public function create()
    {
            if (!PermisosHelper::tienePermiso('Reparaciones', 'crear')) {
        abort(403);
    }
        return view('reparaciones.create');
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
        return view('reparaciones.edit', compact('reparacion'));
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

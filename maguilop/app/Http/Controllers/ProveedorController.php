<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Persona;
use App\Models\Empresa;
use App\Helpers\PermisosHelper;
use PDF;

class ProveedorController extends Controller
{
 public function index(Request $request)
{
    $search = $request->input('search');

    $query = Proveedor::with(['persona', 'empresa'])
        ->where(function ($query) use ($search) {
            $query->whereHas('persona', function ($q) use ($search) {
                $q->whereRaw("CONCAT(Nombre, ' ', Apellido) LIKE ?", ["%{$search}%"]);
            })
            ->orWhere('RTN', 'like', "%{$search}%")
            ->orWhere('Descripcion', 'like', "%{$search}%");
        });

    $proveedores = $query->paginate(5);

    return view('proveedores.index', compact('proveedores'));
}

    public function create()
    {
        if (!PermisosHelper::tienePermiso('Proveedores', 'crear')) {
            abort(403);
        }

        $personas = Persona::all();
        $empresas = Empresa::all();

        return view('proveedores.create', compact('personas', 'empresas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'PersonaID' => 'required|integer|exists:persona,PersonaID',
            'EmpresaID' => 'nullable|integer',
            'RTN' => 'nullable|string|max:50',
            'Descripcion' => 'nullable|string',
            'URL_Website' => 'nullable|url|max:255',
            'Ubicacion' => 'nullable|string|max:255',
            'Telefono' => 'nullable|string|max:50',
            'CorreoElectronico' => 'nullable|email|max:255',
            'TipoProveedor' => 'required|in:Local,Internacional',
            'FechaRegistro' => 'required|date',
            'Estado' => 'required|in:Activo,Inactivo',
            'Notas' => 'nullable|string',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor registrado correctamente.');
    }

    public function edit($id)
    {
        if (!PermisosHelper::tienePermiso('Proveedores', 'editar')) {
            abort(403);
        }

        $proveedor = Proveedor::findOrFail($id);
        $personas = Persona::all();
        $empresas = Empresa::all();

        return view('proveedores.edit', compact('proveedor', 'personas', 'empresas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'PersonaID' => 'required|integer|exists:persona,PersonaID',
            'EmpresaID' => 'nullable|integer',
            'RTN' => 'nullable|string|max:50',
            'Descripcion' => 'nullable|string',
            'URL_Website' => 'nullable|url|max:255',
            'Ubicacion' => 'nullable|string|max:255',
            'Telefono' => 'nullable|string|max:50',
            'CorreoElectronico' => 'nullable|email|max:255',
            'TipoProveedor' => 'required|in:Local,Internacional',
            'FechaRegistro' => 'required|date',
            'Estado' => 'required|in:Activo,Inactivo',
            'Notas' => 'nullable|string',
        ]);

        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy($id)
    {
        if (!PermisosHelper::tienePermiso('Proveedores', 'eliminar')) {
            abort(403);
        }

        $proveedor = Proveedor::findOrFail($id);

        // Si tienes la relación compras() definida en el modelo Proveedor
        if (method_exists($proveedor, 'compras') && $proveedor->compras()->exists()) {
            return redirect()->route('proveedores.index')->with('error', 'No se puede eliminar el proveedor porque tiene compras asociadas.');
        }

        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }
public function exportarPDF(Request $request)
{
    $search = $request->input('search');

    $proveedores = Proveedor::with(['persona', 'empresa'])
        ->where(function ($query) use ($search) {
            $query->whereHas('persona', function ($q) use ($search) {
                // Concatenamos Nombre y Apellido para filtrar
                $q->whereRaw("CONCAT(Nombre, ' ', Apellido) LIKE ?", ["%{$search}%"]);
            })
            ->orWhere('RTN', 'like', "%{$search}%")
            ->orWhere('Descripcion', 'like', "%{$search}%");
        })
        ->get();

    $pdf = \PDF::loadView('proveedores.pdf', compact('proveedores'))
        ->setPaper('a4', 'landscape');

    return $pdf->download('proveedores.pdf');

    $pdf = \PDF::loadView('proveedores.pdf', compact('proveedores'))
      ->setPaper('a4', 'landscape');

}

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;

class RolController extends Controller
{
    public function index()
    {
        $roles = DB::table('tbl_roles')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Descripcion' => 'required|string|max:100',
            'Estado' => 'required|string|max:20',
        ]);

        DB::table('tbl_roles')->insert([
            'Descripcion' => $request->Descripcion,
            'Estado' => $request->Estado,
            'UsuarioRegistro' => auth()->user()->NombreUsuario ?? 'sistema',
            'FEC_Registro' => Carbon::now(),
        ]);

        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
    }

    public function edit($id)
    {
        $rol = DB::table('tbl_roles')->where('ID_Rol', $id)->first();
        return view('roles.edit', compact('rol'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Descripcion' => 'required|string|max:100',
            'Estado' => 'required|string|max:20',
        ]);

        DB::table('tbl_roles')->where('ID_Rol', $id)->update([
            'Descripcion' => $request->Descripcion,
            'Estado' => $request->Estado,
        ]);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy($id)
    {
        DB::table('tbl_roles')->where('ID_Rol', $id)->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
    }

    public function editPermisos($id)
{
    $rol = DB::table('tbl_roles')->where('ID_Rol', $id)->first();

    $permisos = DB::table('permiso')->get();

    $permisosAsignados = DB::table('rol_permiso')
        ->where('ID_Rol', $id)
        ->pluck('PermisoID')
        ->toArray();

    return view('roles.permisos', compact('rol', 'permisos', 'permisosAsignados'));
}

public function updatePermisos(Request $request, $id)
{
    // Elimina todos los permisos anteriores del rol
    DB::table('rol_permiso')->where('ID_Rol', $id)->delete();

    // Inserta los nuevos permisos seleccionados
    if ($request->has('permisos')) {
        foreach ($request->permisos as $permisoID) {
            DB::table('rol_permiso')->insert([
                'ID_Rol' => $id,
                'PermisoID' => $permisoID,
            ]);
        }
    }

    return redirect()->route('roles.index')->with('success', 'Permisos actualizados correctamente.');
}

}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
use App\Helpers\PermisosHelper;

class UsuarioController extends Controller
{
    public function index()
    {
        if (!PermisosHelper::tienePermiso('Usuarios', 'ver')) {
        abort(403, 'No tienes permiso para ver esta sección.');
    }
        $usuarios = DB::table('usuario')->get();
        return view('usuarios.index', compact('usuarios'));
    }

public function create()
{
    // Cargar los roles desde la base de datos
    $roles = DB::table('tbl_roles')
        ->where('Estado', 'Activo') // Opcional: solo roles activos
        ->pluck('Descripcion', 'ID_Rol'); // Devuelve un array ID => Nombre

    $empleados = DB::table('empleado')
        ->join('persona', 'empleado.PersonaID', '=', 'persona.PersonaID')
        ->select('empleado.EmpleadoID', DB::raw("CONCAT(persona.Nombre, ' ', persona.Apellido) as nombre_completo"))
        ->get();

    return view('usuarios.create', compact('roles', 'empleados'));
}



public function store(Request $request)
{
    $request->validate([
        'NombreUsuario' => 'required|string|unique:usuario,NombreUsuario',
        'TipoUsuario' => 'required|string',
        'password' => 'required|string|min:6',
        'EmpleadoID' => 'required|integer|exists:empleado,EmpleadoID',
        'correo' => 'required|email|unique:usuario,CorreoElectronico',
    ]);

    DB::table('usuario')->insert([
        'NombreUsuario' => $request->NombreUsuario,
        'TipoUsuario' => $request->TipoUsuario,
        'EmpleadoID' => $request->EmpleadoID,
        'Contrasena' => bcrypt($request->password),
        'Estado' => 'Activo',
        'PrimerAcceso' => 1,
        'UsuarioRegistro' => auth()->user()->NombreUsuario,
        'FechaRegistro' => now(),
        'CorreoElectronico' => $request->correo,
    ]);

    return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
}

public function edit($id)
{
    $usuario = DB::table('usuario')->where('UsuarioID', $id)->first();

    $empleados = DB::table('empleado')
        ->join('persona', 'empleado.PersonaID', '=', 'persona.PersonaID')
        ->select('empleado.EmpleadoID', DB::raw("CONCAT(persona.Nombre, ' ', persona.Apellido) as NombreCompleto"))
        ->get();

    $roles = DB::table('tbl_roles')->pluck('Descripcion');

    return view('usuarios.edit', compact('usuario', 'empleados', 'roles'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'nombre_usuario' => 'required',
        'correo' => 'required|email',
        'rol' => 'required',
        'empleado' => 'required',
    ]);

    DB::table('usuario')->where('UsuarioID', $id)->update([
        'NombreUsuario' => $request->nombre_usuario,
        'CorreoElectronico' => $request->correo,
        'TipoUsuario' => $request->rol,
        'EmpleadoID' => $request->empleado,
    ]);

    return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
}

public function destroy($id)
{
    DB::table('usuario')->where('UsuarioID', $id)->delete();
    //return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    return redirect()->back()->with('success', 'Permisos actualizados correctamente.');
}


}



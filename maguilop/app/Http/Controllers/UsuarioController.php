<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;


class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = DB::table('usuario')->get();
        return view('usuarios.index', compact('usuarios'));
    }

public function create()
{
    $roles = ['Administrador', 'Técnico'];

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
    ]);

    return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
}



}



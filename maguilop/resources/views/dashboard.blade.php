<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard de Seguridad 🔐
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold">Bienvenido, {{ Auth::user()->NombreUsuario }}</h3>
                <p>Desde aquí podrás administrar usuarios, roles y permisos del sistema.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('usuarios.index') }}" class="bg-blue-100 hover:bg-blue-200 p-4 rounded shadow text-center font-medium">👥 Usuarios</a>
                <a href="{{ route('roles.index') }}" class="bg-green-100 hover:bg-green-200 p-4 rounded shadow text-center font-medium">🔐 Roles</a>
                <a href="{{ route('permisos.index') }}" class="bg-yellow-100 hover:bg-yellow-200 p-4 rounded shadow text-center font-medium">⚙️ Permisos</a>
            </div>
        </div>
    </div>
</x-app-layout>


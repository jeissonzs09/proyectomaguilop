<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold">Bienvenido, {{ Auth::user()->NombreUsuario }}</h3>
                <p>Desde aquí podrás administrar usuarios, roles y permisos del sistema.</p>
            </div>
        </div>
    </div>
</x-app-layout>


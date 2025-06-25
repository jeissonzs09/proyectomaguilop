<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">➕ Nuevo Usuario</h2>
    </x-slot>

    <div class="p-6 max-w-xl mx-auto bg-white rounded shadow">
        <form method="POST" action="{{ route('usuarios.store') }}">
            @csrf

            {{-- Nombre de Usuario --}}
            <div class="mb-4">
                <label class="block text-sm font-medium">Nombre de Usuario</label>
                <input type="text" name="NombreUsuario" required class="mt-1 block w-full rounded border-gray-300 shadow-sm" />
                @error('NombreUsuario')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
@enderror

            </div>

            {{-- Rol --}}
            <div class="mb-4">
                <label class="block text-sm font-medium">Rol</label>
                <select name="TipoUsuario" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                    <option value="Administrador">Administrador</option>
                    <option value="Técnico">Técnico</option>
                </select>
                @error('Rol')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
@enderror

            </div>

            {{-- Contraseña --}}
            <div class="mb-4">
                <label class="block text-sm font-medium">Contraseña</label>
                <input type="password" name="password" required class="mt-1 block w-full rounded border-gray-300 shadow-sm" />

                
    @error('password')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
            </div>

            <div class="mb-4">
    <label for="EmpleadoID" class="block text-sm font-medium text-gray-700">Empleado</label>
    <select id="EmpleadoID" name="EmpleadoID" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        @foreach($empleados as $empleado)
<option value="{{ $empleado->EmpleadoID }}">{{ $empleado->nombre_completo }}</option>

        @endforeach
    </select>
</div>


            {{-- Botones --}}
            <div class="flex justify-between mt-6">
                <a href="{{ route('usuarios.index') }}" class="text-sm text-gray-600 hover:underline">← Cancelar</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded">
                    Guardar Usuario
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

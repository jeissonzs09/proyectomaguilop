<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">✏️ Editar Usuario</h2>
    </x-slot>

    <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <form method="POST" action="{{ route('usuarios.update', $usuario->UsuarioID) }}">
            @csrf
            @method('PUT')

            <!-- Nombre de usuario -->
            <div class="mb-4">
                <label for="nombre_usuario" class="block text-gray-700 font-semibold mb-2">Nombre de usuario</label>
                <input type="text" id="nombre_usuario" name="nombre_usuario"
                       value="{{ old('nombre_usuario', $usuario->NombreUsuario) }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Correo electrónico -->
            <div class="mb-4">
                <label for="correo" class="block text-gray-700 font-semibold mb-2">Correo electrónico</label>
                <input type="email" id="correo" name="correo"
                       value="{{ old('correo', $usuario->CorreoElectronico) }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Rol -->
            <div class="mb-4">
                <label for="rol" class="block text-gray-700 font-semibold mb-2">Rol</label>
                <select name="rol" id="rol"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="Administrador" {{ $usuario->TipoUsuario == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                    <option value="Técnico" {{ $usuario->TipoUsuario == 'Técnico' ? 'selected' : '' }}>Técnico</option>
                </select>
            </div>

            <!-- Empleado -->
            <div class="mb-4">
                <label for="empleado" class="block text-gray-700 font-semibold mb-2">Empleado vinculado</label>
                <select name="empleado" id="empleado"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @foreach($empleados as $empleado)
                        <option value="{{ $empleado->EmpleadoID }}" {{ $empleado->EmpleadoID == $usuario->EmpleadoID ? 'selected' : '' }}>
                            {{ $empleado->NombreCompleto }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Botón Guardar -->
            <div class="mt-6 text-end">
                <a href="{{ route('usuarios.index') }}"
   style="background-color: #dc2626; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); text-decoration: none;">
   ❌ Cancelar
</a>
<button type="submit"
    style="background-color: #2563eb; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); border: none;">
    💾 Guardar cambios
</button>


            </div>
        </form>
    </div>
</x-app-layout>

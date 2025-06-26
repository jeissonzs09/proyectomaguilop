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
                @error('nombre_usuario')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Correo electrónico -->
            <div class="mb-4">
                <label for="correo" class="block text-gray-700 font-semibold mb-2">Correo electrónico</label>
                <input type="email" id="correo" name="correo"
                       value="{{ old('correo', $usuario->CorreoElectronico) }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('correo')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rol dinámico -->
            <div class="mb-4">
                <label for="rol" class="block text-gray-700 font-semibold mb-2">Rol</label>
                <select name="rol" id="rol"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Seleccione un rol</option>
                    @foreach($roles as $descripcion)
                        <option value="{{ $descripcion }}" {{ $usuario->TipoUsuario == $descripcion ? 'selected' : '' }}>
                            {{ $descripcion }}
                        </option>
                    @endforeach
                </select>
                @error('rol')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Empleado -->
            <div class="mb-4">
                <label for="empleado" class="block text-gray-700 font-semibold mb-2">Empleado vinculado</label>
                <select name="empleado" id="empleado"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Seleccione un empleado</option>
                    @foreach($empleados as $empleado)
                        <option value="{{ $empleado->EmpleadoID }}" {{ $empleado->EmpleadoID == $usuario->EmpleadoID ? 'selected' : '' }}>
                            {{ $empleado->NombreCompleto }}
                        </option>
                    @endforeach
                </select>
                @error('empleado')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botón Guardar -->
            <div class="mt-6 text-end">
                <a href="{{ route('usuarios.index') }}"
                   style="background-color: #dc2626; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
                   ❌ Cancelar
                </a>
                <button type="submit"
                        style="background-color: #2563eb; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; border: none;">
                    💾 Guardar cambios
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

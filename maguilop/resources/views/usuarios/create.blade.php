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
                <input type="text" name="NombreUsuario" value="{{ old('NombreUsuario') }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm" />
                @error('NombreUsuario')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Rol dinámico desde base de datos --}}
            <div class="mb-4">
                <label class="block text-sm font-medium">Rol</label>
                <select name="TipoUsuario" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                    <option value="">Seleccione un rol</option>
                    @foreach($roles as $id => $descripcion)
                        <option value="{{ $descripcion }}" {{ old('TipoUsuario') == $descripcion ? 'selected' : '' }}>
                            {{ $descripcion }}
                        </option>
                    @endforeach
                </select>
                @error('TipoUsuario')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Correo Electrónico --}}
            <div class="mb-4">
                <label class="block text-sm font-medium">Correo Electrónico</label>
                <input type="email" name="correo" value="{{ old('correo') }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm" />
                @error('correo')
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

            {{-- Empleado --}}
            <div class="mb-4">
                <label for="EmpleadoID" class="block text-sm font-medium text-gray-700">Empleado</label>
                <select id="EmpleadoID" name="EmpleadoID" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Seleccione un empleado</option>
                    @foreach($empleados as $empleado)
                        <option value="{{ $empleado->EmpleadoID }}" {{ old('EmpleadoID') == $empleado->EmpleadoID ? 'selected' : '' }}>
                            {{ $empleado->nombre_completo }}
                        </option>
                    @endforeach
                </select>
                @error('EmpleadoID')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botones --}}
            <div class="flex justify-between mt-6">
                <a href="{{ route('usuarios.index') }}"
                   style="background-color: #dc2626; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); text-decoration: none;">
                   ❌ Cancelar
                </a>
                <button type="submit"
                        style="background-color: #2563eb; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); border: none;">
                    💾 Guardar usuario
                </button>
            </div>
        </form>
    </div>
</x-app-layout>


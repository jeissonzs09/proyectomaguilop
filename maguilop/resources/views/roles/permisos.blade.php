<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🔐 Asignar Permisos al Rol: {{ $rol->Descripcion }}</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('roles.permisos.update', $rol->ID_Rol) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <h3 class="text-lg font-semibold mb-2">Permisos disponibles:</h3>
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($permisos as $permiso)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox"
                                   name="permisos[]"
                                   value="{{ $permiso->PermisoID }}"
                                   {{ in_array($permiso->PermisoID, $permisosAsignados) ? 'checked' : '' }}>
                            <span>{{ $permiso->NombrePermiso }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('roles.index') }}"
                   style="background-color: #dc2626; color: white; padding: 10px 20px; border-radius: 8px;">
                    ← Cancelar
                </a>
                <button type="submit"
                        style="background-color: #2563eb; color: white; padding: 10px 20px; border-radius: 8px;">
                    💾 Guardar Permisos
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

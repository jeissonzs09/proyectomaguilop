<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🔐 Gestión de Roles</h2>
    </x-slot>

     @php
        $permisos = \App\Helpers\PermisosHelper::class;
    @endphp

    <div class="p-4">
        {{-- Botón para agregar nuevo rol --}}
                @if($permisos::tienePermiso('Roles', 'crear'))
        <a href="{{ route('roles.create') }}"
           style="background-color: #2563eb; color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            ➕ Nuevo rol
        </a>
        @endif

        {{-- Tabla de roles --}}
        <table class="table-auto w-full mt-4 border rounded shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-center">ID</th>
                    <th class="border px-4 py-2 text-center">Descripción</th>
                    <th class="border px-4 py-2 text-center">Estado</th>
                    <th class="border px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $rol)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 text-center">{{ $rol->ID_Rol }}</td>
                    <td class="border px-4 py-2 text-center">{{ $rol->Descripcion }}</td>
                    <td class="border px-4 py-2 text-center">{{ $rol->Estado }}</td>
                    <td class="px-4 py-2 text-center space-x-2">
                        {{-- Botón editar --}}
                        @if($permisos::tienePermiso('Roles', 'editar'))
                        <a href="{{ route('roles.edit', $rol->ID_Rol) }}"
                           style="background-color: #f59e0b; color: white; padding: 8px; border-radius: 50%; display: inline-block;"
                           title="Editar">
                            ✏️
                        </a>
                        @endif

                        {{-- Botón eliminar --}}
                        @if($permisos::tienePermiso('Roles', 'elimiar'))
                        <form action="{{ route('roles.destroy', $rol->ID_Rol) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este rol?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="background-color: #dc2626; color: white; padding: 8px; border-radius: 50%; display: inline-block;"
                                    title="Eliminar">
                                🗑️
                            </button>
                        </form>
                        {{-- Botón Asignar Permisos --}}
                        <a href="{{ route('roles.permisos.edit', $rol->ID_Rol) }}"
                        style="background-color: #16a34a; color: white; padding: 8px; border-radius: 50%; display: inline-block;"
                         title="Asignar Permisos">
                        ⚙️
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>




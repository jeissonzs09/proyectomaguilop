<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">👥 Usuarios</h2>
    </x-slot>

    @php
        $permisos = \App\Helpers\PermisosHelper::class;
    @endphp

    <div class="p-4">
        {{-- Botón de crear usuario --}}
        @if($permisos::tienePermiso('Usuarios', 'crear'))
            <a href="{{ route('usuarios.create') }}"
            style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 0.5rem; display: inline-flex; align-items: center; gap: 8px; font-weight: bold;">
                ➕ Nuevo usuario
            </a>
        @endif

        <table class="table-auto w-full mt-4 border rounded-lg shadow">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="border px-4 py-2 text-center">ID</th>
                    <th class="border px-4 py-2 text-center">Usuario</th>
                    <th class="border px-4 py-2 text-center">Rol</th>
                    <th class="border px-4 py-2 text-center">Correo</th>
                    <th class="border px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 text-center">{{ $usuario->UsuarioID }}</td>
                        <td class="border px-4 py-2">{{ $usuario->NombreUsuario }}</td>
                        <td class="border px-4 py-2">{{ $usuario->TipoUsuario }}</td>
                        <td class="border px-4 py-2">{{ $usuario->CorreoElectronico }}</td>
                        <td class="px-4 py-2 text-center space-x-2">
                            {{-- Editar --}}
                            @if($permisos::tienePermiso('Usuarios', 'editar'))
                                <a href="{{ route('usuarios.edit', $usuario->UsuarioID) }}"
                                style="display: inline-flex; align-items: center; justify-content: center; background-color:rgb(248, 245, 32); color: white; padding: 0.5rem; border-radius: 9999px; transition: background-color 0.2s ease;"
                                onmouseover="this.style.backgroundColor='#1e40af'"
                                onmouseout="this.style.backgroundColor='#2563eb'"
                                   title="Editar">
                                    ✏️
                                </a>
                            @endif

                            {{-- Eliminar --}}
                            @if($permisos::tienePermiso('Usuarios', 'eliminar'))
                                <form action="{{ route('usuarios.destroy', $usuario->UsuarioID) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('¿Estás seguro de eliminar este usuario?')"
                                            class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white p-2 rounded-full transition duration-200"
                                            title="Eliminar">
                                        🗑️
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>





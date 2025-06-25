<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">👥 Usuarios</h2>
    </x-slot>

    <div class="p-4">
        <a href="{{ route('usuarios.create') }}" class="bg-blue-600 text-black px-4 py-2 rounded">+ Nuevo usuario</a>
<table class="table-auto w-full mt-4 border rounded-lg shadow">
    <thead class="bg-gray-100 text-gray-700">
        <tr>
            <th class="border px-4 py-2">ID</th>
            <th class="border px-4 py-2">Usuario</th>
            <th class="border px-4 py-2">Rol</th>
            <th class="border px-4 py-2 text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usuarios as $usuario)
        <tr class="hover:bg-gray-50">
            <td class="border px-4 py-2">{{ $usuario->UsuarioID }}</td>
            <td class="border px-4 py-2">{{ $usuario->NombreUsuario }}</td>
            <td class="border px-4 py-2">{{ $usuario->TipoUsuario }}</td>
<td class="px-4 py-2 text-center space-x-2">
    <a href="{{ route('usuarios.edit', $usuario->UsuarioID) }}"
       class="inline-flex items-center justify-center bg-red-500 hover:bg-blue-600 text-white p-2 rounded-full transition duration-200"
       title="Editar">
        ✏️
    </a>

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

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
    </div>
</x-app-layout>



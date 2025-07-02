<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold flex items-center gap-2">
            <i class="fas fa-users"></i> Clientes
        </h2>
    </x-slot>

    @php
        $permisos = \App\Helpers\PermisosHelper::class;
    @endphp

    <div class="p-4">
        {{-- Botón de crear cliente --}}
        @if($permisos::tienePermiso('Clientes', 'crear'))
        <a href="{{ route('clientes.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow font-bold">
            <i class="fas fa-plus"></i> Nuevo cliente
        </a>
        @endif

        <div class="overflow-x-auto bg-white rounded-lg shadow mt-4">
            <table class="min-w-full text-sm text-gray-800">
<thead class="bg-orange-500 text-white text-sm uppercase">
    <tr>
        <th class="px-4 py-3 text-center">Cliente ID</th>
        <th class="px-4 py-3 text-left">Nombre Cliente</th>
        <th class="px-4 py-3 text-left">Persona ID</th>
        <th class="px-4 py-3 text-left">Categoría</th>
        <th class="px-4 py-3 text-left">Fecha Registro</th>
        <th class="px-4 py-3 text-left">Estado</th>
        <th class="px-4 py-3 text-left">Notas</th>
        <th class="px-4 py-3 text-center">Acciones</th>
    </tr>
</thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($clientes as $cliente)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 text-center">{{ $cliente->ClienteID }}</td>
                            <td class="px-4 py-2">{{ $cliente->NombreCliente }}</td>
                            <td class="px-4 py-2">{{ $cliente->PersonaID }}</td>
                            <td class="px-4 py-2">{{ $cliente->Categoria }}</td>
                            <td class="px-4 py-2">{{ $cliente->FechaRegistro }}</td>
                            <td class="px-4 py-2">{{ $cliente->Estado }}</td>
                            <td class="px-4 py-2">{{ $cliente->Notas }}</td>
                            <td class="px-4 py-2 text-center space-x-2">
                                {{-- Editar --}}
                                @if($permisos::tienePermiso('Clientes', 'editar'))
                                <a href="{{ route('clientes.edit', $cliente->ClienteID) }}"
                                           class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-full"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                </a>
                                @endif

                                {{-- Eliminar --}}
                                @if($permisos::tienePermiso('Clientes', 'eliminar'))
                                <form action="{{ route('clientes.destroy', $cliente->ClienteID) }}" method="POST" class="inline-block"
                                      onsubmit="return confirm('¿Estás seguro de eliminar este cliente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-full"
                                            title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

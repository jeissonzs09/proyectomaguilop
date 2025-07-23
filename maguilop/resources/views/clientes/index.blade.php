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
        {{-- Mensajes --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- Botones --}}
        <div class="flex items-center gap-3 mb-6 flex-wrap">
            @if($permisos::tienePermiso('Clientes', 'crear'))
                <a href="{{ route('clientes.create') }}"
                   class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow font-bold">
                    <i class="fas fa-plus"></i> Nuevo cliente
                </a>
            @endif

            @if($permisos::tienePermiso('Clientes', 'ver'))
    <a href="{{ route('clientes.exportarPDF', ['search' => request('search')]) }}"
       class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md shadow whitespace-nowrap">
        <i class="fas fa-file-pdf"></i> Exportar PDF
    </a>
@endif


            <div class="relative max-w-xs w-full ml-auto">
                <input
                    type="text"
                    x-data="{ search: '{{ request('search') }}' }"
                    x-model="search"
                    @input.debounce.500="window.location.href = '?search=' + encodeURIComponent(search)"
                    placeholder="Buscar cliente..."
                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none text-sm"
                />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-4.35-4.35m1.44-5.4a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="overflow-x-auto bg-white rounded-lg shadow mt-4">
            <table class="min-w-full text-sm text-gray-800">
                <thead class="bg-orange-500 text-white text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3 text-center">Cliente ID</th>
                        <th class="px-4 py-3 text-left">Nombre Cliente</th>
                        <th class="px-4 py-3 text-left">Persona</th>
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
                            <td class="px-4 py-2">{{ $cliente->NombreCliente ?? '—' }}</td>
                            <td class="px-4 py-2">
                                {{ optional($cliente->persona)->Nombre ?? '' }} {{ optional($cliente->persona)->Apellido ?? '' }}
                            </td>
                            <td class="px-4 py-2">{{ $cliente->Categoria }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($cliente->FechaRegistro)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ $cliente->Estado }}</td>
                            <td class="px-4 py-2">{{ $cliente->Notas ?? '—' }}</td>
                            <td class="px-4 py-2 text-center space-x-2">
                                @if($permisos::tienePermiso('Clientes', 'editar'))
                                    <a href="{{ route('clientes.edit', $cliente->ClienteID) }}"
                                       class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-full"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
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

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $clientes->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold flex items-center gap-2">
            <i class="fas fa-shopping-cart"></i> Ventas
        </h2>
    </x-slot>

    @php
        $permisos = \App\Helpers\PermisosHelper::class;
    @endphp

<div class="flex items-center gap-3 mb-6 flex-wrap">

    {{-- Crear venta --}}
    @if($permisos::tienePermiso('Ventas', 'crear'))
        <a href="{{ route('ventas.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow whitespace-nowrap">
            <i class="fas fa-plus"></i> Nueva venta
        </a>
    @endif

    {{-- Exportar PDF --}}
    <a href="{{ route('ventas.exportarPDF', ['search' => request('search')]) }}"
       class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md shadow whitespace-nowrap">
        <i class="fas fa-file-pdf"></i> Exportar PDF
    </a>

    {{-- Buscador reactivo con lupa --}}
    
          <div class="relative max-w-xs w-full ml-auto"> <!-- Alinea el buscador a la derecha -->
        <input
            type="text"
            x-data="{ search: '{{ request('search') }}' }"
            x-model="search"
            @input.debounce.500="window.location.href = '?search=' + encodeURIComponent(search)"
            placeholder="Buscar venta..."
            class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none text-sm"
        />
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 21l-4.35-4.35m1.44-5.4a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

</div>


        <div class="overflow-x-auto bg-white rounded-lg shadow mt-4">
            <table class="min-w-full text-sm text-gray-800">
                <thead class="bg-orange-500 text-white text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3 text-center">Venta ID</th>
                        <th class="px-4 py-3 text-center">Cliente</th>
                        <th class="px-4 py-3 text-center">Empleado</th>
                        <th class="px-4 py-3 text-center">Fecha Venta</th>
                        <th class="px-4 py-3 text-left">Producto</th>
                        <th class="px-4 py-3 text-center">Total Venta</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($ventas as $venta)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 text-center">{{ $venta->VentaID }}</td>
                            <td class="px-4 py-2 text-center">
    {{ $venta->cliente->NombreCliente ?? '—' }}
</td>
<td class="px-4 py-2 text-center">
    {{ $venta->empleado->persona->NombreCompleto ?? '—' }}
</td>
                            <td class="px-4 py-2 text-center">{{ $venta->FechaVenta }}</td>
                            <td class="px-4 py-2">
    {{ $venta->producto->NombreProducto ?? '—' }}
</td>
                            <td class="px-4 py-2 text-center">L. {{ number_format($venta->TotalVenta, 2) }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Editar --}}
                                    @if($permisos::tienePermiso('Ventas', 'editar'))
                                        <a href="{{ route('ventas.edit', $venta->VentaID) }}"
                                           class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    {{-- Eliminar --}}
                                    @if($permisos::tienePermiso('Ventas', 'eliminar'))
                                        <form action="{{ route('ventas.destroy', $venta->VentaID) }}" method="POST"
                                              onsubmit="return confirm('¿Estás seguro de eliminar esta venta?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-full"
                                                    title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
<div class="mt-4">
    {{ $ventas->appends(['search' => request('search')])->links() }}
</div>
    </div>
</x-app-layout>

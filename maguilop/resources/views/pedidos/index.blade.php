<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold flex items-center gap-2">
            <i class="fas fa-clipboard-list"></i> Pedidos y Detalles
        </h2>
    </x-slot>

    @php
        $permisos = \App\Helpers\PermisosHelper::class;
    @endphp

    <div class="flex items-center gap-3 mb-6 flex-wrap">
    {{-- Crear pedido --}}
    @if($permisos::tienePermiso('Pedidos', 'crear'))
        <a href="{{ route('pedidos.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow whitespace-nowrap">
            <i class="fas fa-plus"></i> Nuevo pedido
        </a>
    @endif

    {{-- Exportar PDF --}}
    <a href="{{ route('pedidos.exportarPDF', ['search' => request('search')]) }}"
       class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md shadow whitespace-nowrap">
        <i class="fas fa-file-pdf"></i> Exportar PDF
    </a>

    {{-- Buscador reactivo con lupa --}}
    <div class="relative max-w-xs w-full">
        <input
            type="text"
            x-data="{ search: '{{ request('search') }}' }"
            x-model="search"
            @input.debounce.500="window.location.href = '?search=' + encodeURIComponent(search)"
            placeholder="Buscar pedido..."
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
                        <th class="px-4 py-3 text-center">Pedido ID</th>
                        <th class="px-4 py-3 text-center">Cliente</th>
                        <th class="px-4 py-3 text-center">Empleado</th>
                        <th class="px-4 py-3 text-center">Fecha Pedido</th>
                        <th class="px-4 py-3 text-center">Fecha Entrega</th>
                        <th class="px-4 py-3 text-center">Estado</th>
                        <th class="px-4 py-3 text-center">Producto</th>
                        <th class="px-4 py-3 text-center">Cantidad</th>
                        <th class="px-4 py-3 text-right">Precio Unitario</th>
                        <th class="px-4 py-3 text-right">Subtotal</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($pedidos as $pedido)
                        @foreach($pedido->detalles as $detalle)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-2 text-center">{{ $pedido->PedidoID }}</td>
                                <td>{{ $pedido->cliente->NombreCliente ?? '—' }}</td>
                                <td>{{ $pedido->empleado->persona->NombreCompleto ?? '—' }}</td>
                                <td class="px-4 py-2 text-center">{{ $pedido->FechaPedido }}</td>
                                <td class="px-4 py-2 text-center">{{ $pedido->FechaEntrega }}</td>
                                <td class="px-4 py-2 text-center">{{ $pedido->Estado }}</td>
                                <td>
    @foreach ($pedido->detalles as $detalle)
        {{ $detalle->producto->NombreProducto ?? '—' }}<br>
    @endforeach
</td>

                                <td class="px-4 py-2 text-center">{{ $detalle->Cantidad }}</td>
                                <td class="px-4 py-2 text-right">L. {{ number_format($detalle->PrecioUnitario, 2) }}</td>
                                <td class="px-4 py-2 text-right">L. {{ number_format($detalle->Subtotal, 2) }}</td>
                                <td class="px-4 py-2 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if($permisos::tienePermiso('Pedidos', 'editar'))
                                            <a href="{{ route('pedidos.edit', $pedido->PedidoID) }}"
                                           class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-full"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        @if($permisos::tienePermiso('Pedidos', 'eliminar'))
                                            <form action="{{ route('pedidos.destroy', $pedido->PedidoID) }}" method="POST"
                                                  onsubmit="return confirm('¿Seguro de eliminar este pedido?')">
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
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
    {{ $pedidos->appends(['search' => request('search')])->links() }}
</div>
    </div>
</x-app-layout>


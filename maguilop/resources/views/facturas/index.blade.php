<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold flex items-center gap-2">
            <i class="fas fa-file-invoice"></i> Facturas
        </h2>
    </x-slot>

    @php
        $permisos = \App\Helpers\PermisosHelper::class;
    @endphp

<div class="flex items-center gap-3 mb-6 flex-wrap">
    {{-- Crear factura --}}
    @if($permisos::tienePermiso('Factura', 'crear'))
        <a href="{{ route('facturas.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow whitespace-nowrap">
            <i class="fas fa-plus"></i> Nueva factura
        </a>
    @endif

    {{-- Exportar PDF --}}
    <a href="{{ route('facturas.exportarPDF', ['search' => request('search')]) }}"
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
            placeholder="Buscar factura..."
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
                        <th class="px-4 py-3 text-center">Factura ID</th>
                        <th class="px-4 py-3 text-center">Cliente </th>
                        <th class="px-4 py-3 text-center">Empleado </th>
                        <th class="px-4 py-3 text-center">Fecha</th>
                        <th class="px-4 py-3 text-center">Total</th>
                        <th class="px-4 py-3 text-center">Producto </th>
                        <th class="px-4 py-3 text-center">Cantidad</th>
                        <th class="px-4 py-3 text-right">Precio Unitario</th>
                        <th class="px-4 py-3 text-right">Subtotal</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($facturas as $factura)
                        @foreach($factura->detalles as $detalle)
                            <tr class="hover:bg-gray-50 transition">
                                @if ($loop->first)
                                    <td class="px-4 py-2 text-center" rowspan="{{ $factura->detalles->count() }}">{{ $factura->FacturaID }}</td>
                                    <td class="px-4 py-2 text-center" rowspan="{{ $factura->detalles->count() }}">{{ $factura->cliente->NombreCliente ?? '—' }}</td>
                                    <td class="px-4 py-2 text-center" rowspan="{{ $factura->detalles->count() }}">{{ $factura->empleado->persona->NombreCompleto ?? '—' }}</td>
                                    <td class="px-4 py-2 text-center" rowspan="{{ $factura->detalles->count() }}">{{ $factura->Fecha }}</td>
                                    <td class="px-4 py-2 text-center" rowspan="{{ $factura->detalles->count() }}">L. {{ number_format($factura->Total, 2) }}</td>
                                @endif
                                <td class="px-4 py-2 text-center">{{ $detalle->producto->NombreProducto ?? '—' }}</td>
                                <td class="px-4 py-2 text-center">{{ $detalle->Cantidad }}</td>
                                <td class="px-4 py-2 text-right">L. {{ number_format($detalle->PrecioUnitario, 2) }}</td>
                                <td class="px-4 py-2 text-right">L. {{ number_format($detalle->Subtotal, 2) }}</td>

                                @if ($loop->last)
                                    <td class="px-4 py-2 text-center" rowspan="{{ $factura->detalles->count() }}">
                                        <div class="flex items-center justify-center gap-2">
                                            @if($permisos::tienePermiso('Factura', 'editar'))
                                                <a href="{{ route('facturas.edit', $factura->FacturaID) }}"
                                                   class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full"
                                                   title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                            @if($permisos::tienePermiso('Factura', 'eliminar'))
                                                <form action="{{ route('facturas.destroy', $factura->FacturaID) }}" method="POST"
                                                      onsubmit="return confirm('¿Estás seguro de eliminar esta factura?')">
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
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
    {{ $facturas->appends(['search' => request('search')])->links() }}
</div>
    </div>
</x-app-layout>

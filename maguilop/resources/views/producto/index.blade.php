<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold flex items-center gap-2">
            <i class="fas fa-box"></i> Productos
        </h2>
    </x-slot>

    @php
        $permisos = \App\Helpers\PermisosHelper::class;
    @endphp

<div class="flex items-center gap-3 mb-6 flex-wrap">

    {{-- Botón crear producto --}}
    @if($permisos::tienePermiso('Productos', 'crear'))
        <a href="{{ route('producto.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow whitespace-nowrap">
            <i class="fas fa-plus"></i> Nuevo producto
        </a>
    @endif

    {{-- Botón PDF --}}
    <a href="{{ route('producto.exportarPDF', ['search' => request('search')]) }}"
       class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md shadow whitespace-nowrap">
        <i class="fas fa-file-pdf"></i> Exportar PDF
    </a>

{{-- Buscador con lupa --}}

       
         <div class="relative max-w-xs w-full ml-auto"> <!-- Alinea el buscador a la derecha -->
            <input
                type="text"
                x-data="{ search: '{{ request('search') }}' }"
                x-model="search"
                @input.debounce.500="window.location.href = '?search=' + encodeURIComponent(search)"
                placeholder="Buscar producto..."
                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none text-sm"
            />
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.44-5.4a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div>


        <div class="overflow-x-auto bg-white rounded-lg shadow mt-4">
            <table class="min-w-full text-sm text-gray-800">
                <thead class="bg-orange-500 text-white text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Nombre Producto</th>
                        <th class="px-4 py-3 text-left">Descripción</th>
                        <th class="px-4 py-3 text-right">Precio Compra</th>
                        <th class="px-4 py-3 text-right">Precio Venta</th>
                        <th class="px-4 py-3 text-center">Stock</th>
                        <th class="px-4 py-3 text-center">Proveedor</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($productos as $producto)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $producto->ProductoID }}</td>
                            <td class="px-4 py-2">{{ $producto->NombreProducto }}</td>
                            <td class="px-4 py-2">{{ $producto->Descripcion }}</td>
                            <td class="px-4 py-2 text-right">L. {{ number_format($producto->PrecioCompra, 2) }}</td>
                            <td class="px-4 py-2 text-right">L. {{ number_format($producto->PrecioVenta, 2) }}</td>
                            <td class="px-4 py-2 text-center">{{ $producto->Stock }}</td>
                            <td class="px-4 py-2 text-center">{{ $producto->proveedor->Descripcion ?? 'Sin proveedor' }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @if($permisos::tienePermiso('Productos', 'editar'))
                                        <a href="{{ route('producto.edit', $producto->ProductoID) }}"
                                           class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-full"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    @if($permisos::tienePermiso('Productos', 'eliminar'))
                                        <form action="{{ route('producto.destroy', $producto->ProductoID) }}" method="POST"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
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
    {{ $productos->appends(['search' => request('search')])->links() }}
</div>

    </div>
</x-app-layout>
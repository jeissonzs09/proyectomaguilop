<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">📦 Productos</h2>
    </x-slot>

    @php
        $permisos = \App\Helpers\PermisosHelper::class;
    @endphp

    <div class="p-4">
        @if($permisos::tienePermiso('Productos', 'crear'))
        <a href="{{ route('producto.create') }}"
                style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 0.5rem; display: inline-flex; align-items: center; gap: 8px; font-weight: bold;"> 
            ➕ Nuevo Producto
        </a>
        @endif

        <table class="table-auto w-full mt-4 border rounded-lg shadow">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="border px-4 py-2 text-center">ID</th>
                    <th class="border px-4 py-2">Nombre Producto</th>
                    <th class="border px-4 py-2">Descripción</th>
                    <th class="border px-4 py-2 text-right">Precio Compra</th>
                    <th class="border px-4 py-2 text-right">Precio Venta</th>
                    <th class="border px-4 py-2 text-center">Stock</th>
                    <th class="border px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 text-center">{{ $producto->ProductoID }}</td>
                        <td class="border px-4 py-2">{{ $producto->NombreProducto }}</td>
                        <td class="border px-4 py-2">{{ $producto->Descripcion }}</td>
                        <td class="border px-4 py-2 text-right">{{ number_format($producto->PrecioCompra, 2) }}</td>
                        <td class="border px-4 py-2 text-right">{{ number_format($producto->PrecioVenta, 2) }}</td>
                        <td class="border px-4 py-2 text-center">{{ $producto->Stock }}</td>
                        <td class="px-4 py-2 text-center space-x-2">

                                @if($permisos::tienePermiso('Productos', 'crear'))
                            <a href="{{ route('producto.edit', $producto->ProductoID) }}"
                                style="display: inline-flex; align-items: center; justify-content: center; background-color:rgb(248, 245, 32); color: white; padding: 0.5rem; border-radius: 9999px; transition: background-color 0.2s ease;"
                                onmouseover="this.style.backgroundColor='#1e40af'"
                                onmouseout="this.style.backgroundColor='#2563eb'"
                               title="Editar">
                                ✏️
                            </a>
                            @endif

                            <form action="{{ route('producto.destroy', $producto->ProductoID) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                              @if($permisos::tienePermiso('Productos', 'crear'))
                                <button type="submit"
                                        onclick="return confirm('¿Estás seguro de eliminar este producto?')"
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

        <div class="mt-4">
            {{ $productos->links() }}
        </div>
    </div>
</x-app-layout>



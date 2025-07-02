<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold flex items-center gap-2">
            <i class="fas fa-file-invoice-dollar"></i> Detalle Compras
        </h2>
    </x-slot>

    @php
        $permisos = \App\Helpers\PermisosHelper::class;
    @endphp

    <div class="p-4">
        @if($permisos::tienePermiso('DetalleCompras', 'crear'))
            <a href="{{ route('detallecompras.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow font-bold">
                <i class="fas fa-plus"></i> Nuevo detalle de compra
            </a>
        @endif

        <div class="overflow-x-auto bg-white rounded-lg shadow mt-4">
            <table class="min-w-full text-sm text-gray-800">
                <thead class="bg-orange-500 text-white text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3 text-center">Detalle Compra ID</th>
                        <th class="px-4 py-3 text-center">Compra ID</th>
                        <th class="px-4 py-3 text-center">Producto ID</th>
                        <th class="px-4 py-3 text-center">Cantidad</th>
                        <th class="px-4 py-3 text-center">Precio Unitario</th>
                        <th class="px-4 py-3 text-center">Subtotal</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($detalleCompras as $detalle)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 text-center">{{ $detalle->DetalleCompraID }}</td>
                            <td class="px-4 py-2 text-center">{{ $detalle->CompraID }}</td>
                            <td class="px-4 py-2 text-center">{{ $detalle->ProductoID }}</td>
                            <td class="px-4 py-2 text-center">{{ $detalle->Cantidad }}</td>
                            <td class="px-4 py-2 text-center">L. {{ number_format($detalle->PrecioUnitario, 2) }}</td>
                            <td class="px-4 py-2 text-center">L. {{ number_format($detalle->Subtotal, 2) }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @if($permisos::tienePermiso('DetalleCompras', 'editar'))
                                        <a href="{{ route('detallecompras.edit', $detalle->DetalleCompraID) }}"
                                           class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-full"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    @if($permisos::tienePermiso('DetalleCompras', 'eliminar'))
                                        <form action="{{ route('detallecompras.destroy', $detalle->DetalleCompraID) }}" method="POST"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este detalle de compra?')">
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
    </div>
</x-app-layout>

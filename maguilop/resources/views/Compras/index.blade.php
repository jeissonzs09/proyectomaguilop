<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold flex items-center gap-2">
            <i class="fas fa-shopping-cart"></i> Compras
        </h2>
    </x-slot>

    @php
        $permisos = \App\Helpers\PermisosHelper::class;
    @endphp

    <div class="p-4">
        @if($permisos::tienePermiso('Compras', 'crear'))
            <a href="{{ route('compras.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow font-bold">
                <i class="fas fa-plus"></i> Nueva Compra
            </a>
        @endif

        <div class="overflow-x-auto bg-white rounded-lg shadow mt-4">
            <table class="min-w-full text-sm text-gray-800">
                <thead class="bg-orange-500 text-white text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3 text-center">Compra ID</th>
                        <th class="px-4 py-3 text-center">Proveedor ID</th>
                        <th class="px-4 py-3 text-center">Empleado ID</th>
                        <th class="px-4 py-3 text-center">Fecha de Compra</th>
                        <th class="px-4 py-3 text-center">Total de Compra</th>
                        <th class="px-4 py-3 text-center">Estado</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($compras as $compra)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 text-center">{{ $compra->CompraID }}</td>
                            <td class="px-4 py-2 text-center">{{ $compra->ProveedorID }}</td>
                            <td class="px-4 py-2 text-center">{{ $compra->EmpleadoID }}</td>
                            <td class="px-4 py-2 text-center">{{ $compra->FechaCompra }}</td>
                            <td class="px-4 py-2 text-center">L. {{ number_format($compra->TotalCompra, 2) }}</td>
                            <td class="px-4 py-2 text-center">{{ $compra->Estado }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @if($permisos::tienePermiso('Compras', 'editar'))
                                        <a href="{{ route('compras.edit', $compra->CompraID) }}"
                                           class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-full"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    @if($permisos::tienePermiso('Compras', 'eliminar'))
                                        <form action="{{ route('compras.destroy', $compra->CompraID) }}" method="POST"
                                              onsubmit="return confirm('¿Estás seguro de eliminar esta compra?')">
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

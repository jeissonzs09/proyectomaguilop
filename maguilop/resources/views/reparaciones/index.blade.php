<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold flex items-center gap-2">
            <i class="fas fa-tools"></i> Reparaciones
        </h2>
    </x-slot>

    @php
        $permisos = \App\Helpers\PermisosHelper::class;
    @endphp

    <div class="p-4">
        {{-- Botón de crear reparación --}}
        @if($permisos::tienePermiso('Reparaciones', 'crear'))
            <a href="{{ route('reparaciones.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow">
                <i class="fas fa-plus"></i> Nueva reparación
            </a>
        @endif

        <div class="overflow-x-auto bg-white rounded-lg shadow mt-4">
            <table class="min-w-full text-sm text-gray-800">
                <thead class="bg-orange-500 text-white text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Cliente</th>
                        <th class="px-4 py-3 text-left">Producto</th>
                        <th class="px-4 py-3 text-left">Entrada</th>
                        <th class="px-4 py-3 text-left">Salida</th>
                        <th class="px-4 py-3 text-left">Problema</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-left">Costo</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($reparaciones as $reparacion)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $reparacion->ReparacionID }}</td>
                            <td class="px-4 py-2">{{ $reparacion->ClienteID }}</td>
                            <td class="px-4 py-2">{{ $reparacion->ProductoID }}</td>
                            <td class="px-4 py-2">{{ $reparacion->FechaEntrada }}</td>
                            <td class="px-4 py-2">{{ $reparacion->FechaSalida }}</td>
                            <td class="px-4 py-2">{{ $reparacion->DescripcionProblema }}</td>
                            <td class="px-4 py-2">{{ $reparacion->Estado }}</td>
                            <td class="px-4 py-2">L. {{ number_format($reparacion->Costo, 2) }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Editar --}}
                                    @if($permisos::tienePermiso('Reparaciones', 'editar'))
                                        <a href="{{ route('reparaciones.edit', $reparacion->ReparacionID) }}"
                                           class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-full"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    {{-- Eliminar --}}
                                    @if($permisos::tienePermiso('Reparaciones', 'eliminar'))
                                        <form action="{{ route('reparaciones.destroy', $reparacion->ReparacionID) }}" method="POST"
                                              onsubmit="return confirm('¿Estás seguro de eliminar esta reparación?')">
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




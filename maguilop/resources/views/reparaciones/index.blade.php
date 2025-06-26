<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🛠️ Reparaciones</h2>
    </x-slot>

    @php
        $permisos = \App\Helpers\PermisosHelper::class;
    @endphp

    <div class="p-4">
        {{-- Botón de crear reparación --}}
                @if($permisos::tienePermiso('Reparaciones', 'crear'))
        <a href="{{ route('reparaciones.create') }}"
           style="background-color: #2563eb; color: white; padding: 8px 16px; border-radius: 0.5rem; display: inline-flex; align-items: center; gap: 8px; font-weight: bold;">
            ➕ Nueva reparación
        </a>
        @endif

        <table class="table-auto w-full mt-4 border rounded-lg shadow">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="border px-4 py-2 text-center">ID</th>
                    <th class="border px-4 py-2 text-center">Cliente</th>
                    <th class="border px-4 py-2 text-center">Producto</th>
                    <th class="border px-4 py-2 text-center">Entrada</th>
                    <th class="border px-4 py-2 text-center">Salida</th>
                    <th class="border px-4 py-2 text-center">Problema</th>
                    <th class="border px-4 py-2 text-center">Estado</th>
                    <th class="border px-4 py-2 text-center">Costo</th>
                    <th class="border px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reparaciones as $reparacion)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 text-center">{{ $reparacion->ReparacionID }}</td>
                        <td class="border px-4 py-2">{{ $reparacion->ClienteID }}</td>
                        <td class="border px-4 py-2">{{ $reparacion->ProductoID }}</td>
                        <td class="border px-4 py-2">{{ $reparacion->FechaEntrada }}</td>
                        <td class="border px-4 py-2">{{ $reparacion->FechaSalida }}</td>
                        <td class="border px-4 py-2">{{ $reparacion->DescripcionProblema }}</td>
                        <td class="border px-4 py-2">{{ $reparacion->Estado }}</td>
                        <td class="border px-4 py-2">L. {{ number_format($reparacion->Costo, 2) }}</td>
                        <td class="px-4 py-2 text-center space-x-2">
                            {{-- Editar --}}
                            @if($permisos::tienePermiso('Reparaciones', 'editar'))
                            <a href="{{ route('reparaciones.edit', $reparacion->ReparacionID) }}"
                               class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full transition duration-200"
                               title="Editar">
                                ✏️
                            </a>
                            @endif

                            {{-- Eliminar --}}
                            @if($permisos::tienePermiso('Reparaciones', 'eliminar'))
                            <form action="{{ route('reparaciones.destroy', $reparacion->ReparacionID) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('¿Estás seguro de eliminar esta reparación?')"
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
    </div>
</x-app-layout>



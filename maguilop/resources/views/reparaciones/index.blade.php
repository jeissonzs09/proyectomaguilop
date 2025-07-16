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

<div class="flex items-center gap-3 mb-6 flex-wrap">
    {{-- Botón a la izquierda --}}
    @if($permisos::tienePermiso('Reparaciones', 'crear'))
        <a href="{{ route('reparaciones.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow whitespace-nowrap">
            <i class="fas fa-plus"></i> Nueva reparación
        </a>
    @endif

    {{-- Buscador con ícono de lupa integrado --}}
    <div class="relative max-w-xs w-full">
        <input
            type="text"
            x-data="{ search: '{{ request('search') }}' }"
            x-model="search"
            @input.debounce.500="window.location.href = '?search=' + encodeURIComponent(search)"
            placeholder="Buscar reparación..."
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
                            <td class="px-4 py-2">{{ $reparacion->cliente->NombreCliente }}</td>
                            <td class="px-4 py-2">{{ $reparacion->producto->NombreProducto }}</td>
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




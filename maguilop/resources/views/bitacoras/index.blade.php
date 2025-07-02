<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold flex items-center gap-2">
            <i class="fas fa-scroll"></i> Bitácoras
        </h2>
    </x-slot>

    @php
        $permisos = \App\Helpers\PermisosHelper::class;
    @endphp

    <div class="p-4">
        @if($permisos::tienePermiso('Bitacora', 'crear'))
            <a href="{{ route('bitacoras.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow">
                <i class="fas fa-plus-circle"></i> Nueva Bitácora
            </a>
        @endif

        <div class="overflow-x-auto mt-4 bg-white rounded-lg shadow">
            <table class="min-w-full text-sm text-gray-800">
                <thead class="bg-orange-500 text-white text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Usuario ID</th>
                        <th class="px-4 py-3 text-left">Acción</th>
                        <th class="px-4 py-3 text-left">Tabla</th>
                        <th class="px-4 py-3 text-left">Fecha</th>
                        <th class="px-4 py-3 text-left">Descripción</th>
                        <th class="px-4 py-3 text-left">Datos Previos</th>
                        <th class="px-4 py-3 text-left">Datos Nuevos</th>
                        <th class="px-4 py-3 text-left">Módulo</th>
                        <th class="px-4 py-3 text-left">Resultado</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($bitacoras as $bitacora)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $bitacora->BitacoraID }}</td>
                            <td class="px-4 py-2">{{ $bitacora->UsuarioID }}</td>
                            <td class="px-4 py-2">{{ $bitacora->Accion }}</td>
                            <td class="px-4 py-2">{{ $bitacora->TablaAfectada }}</td>
                            <td class="px-4 py-2">{{ $bitacora->FechaAccion }}</td>
                            <td class="px-4 py-2">{{ $bitacora->Descripcion }}</td>
                            <td class="px-4 py-2 whitespace-pre-line">{{ $bitacora->DatosPrevios }}</td>
                            <td class="px-4 py-2 whitespace-pre-line">{{ $bitacora->DatosNuevos }}</td>
                            <td class="px-4 py-2">{{ $bitacora->Modulo }}</td>
                            <td class="px-4 py-2">{{ $bitacora->Resultado }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @if($permisos::tienePermiso('Bitacora', 'editar'))
                                        <a href="{{ route('bitacoras.edit', $bitacora->BitacoraID) }}"
                                           class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-full"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    @if($permisos::tienePermiso('Bitacora', 'eliminar'))
                                        <form action="{{ route('bitacoras.destroy', $bitacora->BitacoraID) }}" method="POST"
                                              onsubmit="return confirm('¿Estás seguro de eliminar esta bitácora?')">
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

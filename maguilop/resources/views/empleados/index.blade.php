<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold flex items-center gap-2">
            <i class="fas fa-users"></i> Empleados
        </h2>
    </x-slot>

    @php
        $permisos = \App\Helpers\PermisosHelper::class;
    @endphp

    <div class="flex items-center gap-3 mb-6 flex-wrap">
        {{-- Crear empleado --}}
        @if($permisos::tienePermiso('Empleados', 'crear'))
            <a href="{{ route('empleados.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow whitespace-nowrap">
                <i class="fas fa-plus"></i> Nuevo empleado
            </a>
        @endif

        {{-- Exportar PDF --}}
        <a href="{{ route('empleados.exportarPDF', ['search' => request('search')]) }}"
           class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md shadow whitespace-nowrap">
            <i class="fas fa-file-pdf"></i> Exportar PDF
        </a>

        {{-- Buscador --}}
        <div class="relative max-w-xs w-full ml-auto">
            <input
                type="text"
                x-data="{ search: '{{ request('search') }}' }"
                x-model="search"
                @input.debounce.500="window.location.href = '?search=' + encodeURIComponent(search)"
                placeholder="Buscar empleado..."
                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none text-sm"
            />
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 21l-4.35-4.35m1.44-5.4a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow mt-4">
        <table class="min-w-full text-sm text-gray-800">
            <thead class="bg-orange-500 text-white text-sm uppercase">
                <tr>
                    <th class="px-4 py-3 text-center">Empleado ID</th>
                    <th class="px-4 py-3 text-center">Nombre Completo</th>
                    <th class="px-4 py-3 text-center">Departamento</th>
                    <th class="px-4 py-3 text-center">Cargo</th>
                    <th class="px-4 py-3 text-center">Fecha Contratación</th>
                    <th class="px-4 py-3 text-center">Salario</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($empleados as $empleado)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 text-center">{{ $empleado->EmpleadoID }}</td>
                        <td>{{ $empleado->persona->Nombre }} {{ $empleado->persona->Apellido }}</td>

                       <td class="px-4 py-2">{{ $empleado->Departamento ?? '—' }}</td>

                        </td>
                        <td class="px-4 py-2 text-center">{{ $empleado->Cargo }}</td>
                        
                        <td class="px-4 py-2 text-center">{{ $empleado->FechaContratacion }}</td>
                        <td class="px-4 py-2 text-right">L. {{ number_format($empleado->Salario, 2) }}</td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex items-center justify-center gap-2">
                                @if($permisos::tienePermiso('Empleados', 'editar'))
                                    <a href="{{ route('empleados.edit', $empleado->EmpleadoID) }}"
                                       class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-full"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                                @if($permisos::tienePermiso('Empleados', 'eliminar'))
                                    <form action="{{ route('empleados.destroy', $empleado->EmpleadoID) }}" method="POST"
                                          onsubmit="return confirm('¿Seguro de eliminar este empleado?')">
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
    {{ $empleados->appends(['search' => request('search')])->links() }}
</div>
    
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold flex items-center gap-2">
            <i class="fas fa-user-tie"></i> Empleados
        </h2>
    </x-slot>

    @php
        $permisos = \App\Helpers\PermisosHelper::class;
    @endphp

    <div class="p-4">
        @if($permisos::tienePermiso('Empleados', 'crear'))
            <a href="{{ route('empleados.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow">
                <i class="fas fa-plus"></i> Nuevo empleado
            </a>
        @endif

        <div class="overflow-x-auto bg-white rounded-lg shadow mt-4">
            <table class="min-w-full text-sm text-gray-800">
                <thead class="bg-orange-500 text-white text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3 text-center">Empleado ID</th>
                        <th class="px-4 py-3 text-center">Persona ID</th>
                        <th class="px-4 py-3 text-center">Departamento</th>
                        <th class="px-4 py-3 text-center">Cargo</th>
                        <th class="px-4 py-3 text-center">Contratación</th>
                        <th class="px-4 py-3 text-center">Salario</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($empleados as $empleado)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 text-center">{{ $empleado->EmpleadoID }}</td>
                            <td class="px-4 py-2 text-center">{{ $empleado->PersonaID }}</td>
                            <td class="px-4 py-2 text-center">{{ $empleado->Departamento }}</td>
                            <td class="px-4 py-2 text-center">{{ $empleado->Cargo }}</td>
                            <td class="px-4 py-2 text-center">{{ \Carbon\Carbon::parse($empleado->FechaContratacion)->format('Y-m-d') }}</td>
                            <td class="px-4 py-2 text-center">L. {{ number_format($empleado->Salario, 2) }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex justify-center gap-2">
                                    @if($permisos::tienePermiso('Empleados', 'editar'))
                                    <a href="{{ route('empleados.edit', $empleado->EmpleadoID) }}" 
                                  class="inline-flex items-center justify-center bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-full transition duration-200"
                                 title="Editar">
                                  <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    @if($permisos::tienePermiso('Empleados', 'eliminar'))
                                        <form action="{{ route('empleados.destroy', $empleado->EmpleadoID) }}" method="POST"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este empleado?')">
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

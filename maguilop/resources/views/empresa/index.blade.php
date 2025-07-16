<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold flex items-center gap-2">
            <i class="fas fa-building"></i> Empresas
        </h2>
    </x-slot>

    @php
        $permisos = \App\Helpers\PermisosHelper::class;
    @endphp

    <div class="p-4">
        {{-- Mensaje de éxito --}}
@if (session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded shadow text-sm">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
    </div>
@endif

{{-- Mensaje de error --}}
@if (session('error'))
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded shadow text-sm">
        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
    </div>
@endif

        {{-- Botón de crear empresa --}}
        @if($permisos::tienePermiso('Empresas', 'crear'))
            <a href="{{ route('empresa.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow">
                <i class="fas fa-plus"></i> Nueva empresa
            </a>
        @endif

        <div class="overflow-x-auto bg-white rounded-lg shadow mt-4">
            <table class="min-w-full text-sm text-gray-800">
                <thead class="bg-orange-500 text-white text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-left">Teléfono</th>
                        <th class="px-4 py-3 text-left">Website</th>
                        <th class="px-4 py-3 text-left">Dirección</th>
                        <th class="px-4 py-3 text-left">Descripción</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($empresas as $empresa)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $empresa->EmpresaID }}</td>
                            <td class="px-4 py-2">{{ $empresa->NombreEmpresa }}</td>
                            <td class="px-4 py-2">{{ $empresa->Telefono ?? '—' }}</td>
                            <td class="px-4 py-2">{{ $empresa->Website ?? '—' }}</td>
                            <td class="px-4 py-2">{{ $empresa->Direccion ?? '—' }}</td>
                            <td class="px-4 py-2">{{ $empresa->Descripcion ?? '—' }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Editar --}}
                                    @if($permisos::tienePermiso('Empresas', 'editar'))
                                        <a href="{{ route('empresa.edit', $empresa->EmpresaID) }}"
                                           class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-full"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    {{-- Eliminar --}}
                                    @if($permisos::tienePermiso('Empresas', 'eliminar'))
                                        <form action="{{ route('empresa.destroy', $empresa->EmpresaID) }}" method="POST"
                                              onsubmit="return confirm('¿Deseas eliminar esta empresa?')">
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


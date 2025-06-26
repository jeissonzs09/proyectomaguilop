<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🛡️ Asignación de Permisos por Rol y Módulo</h2>
    </x-slot>

    <div class="container mt-4">
        @if(session('success'))
            <div style="background-color: #d1e7dd; color: #0f5132; padding: 12px; border-radius: 6px; margin-bottom: 16px;">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('roles.permisos.guardar') }}">
            @csrf

            <div class="overflow-x-auto">
                <table class="table-auto w-full bg-white border shadow-sm">
                    <thead style="background-color: #ef6c00; color: white;">
                        <tr>
                            <th class="px-4 py-2">Módulo</th>
                            @foreach ($roles as $rol)
                                <th colspan="4" class="text-center px-2">{{ $rol->Descripcion }}</th>
                            @endforeach
                        </tr>
                        <tr>
                            <th></th>
                            @foreach ($roles as $rol)
                                <th class="text-center">Ver</th>
                                <th class="text-center">Crear</th>
                                <th class="text-center">Editar</th>
                                <th class="text-center">Eliminar</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modulos as $modulo)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2 font-semibold">{{ $modulo }}</td>
                                @foreach ($roles as $rol)
                                    @php
                                        $permiso = $permisos[$rol->ID_Rol][$modulo] ?? ['ver' => 0, 'crear' => 0, 'editar' => 0, 'eliminar' => 0];
                                    @endphp

                                    {{-- VER --}}
                                    <td class="border text-center">
                                        <input type="hidden" name="permisos[{{ $rol->ID_Rol }}][{{ $modulo }}][ver]" value="0">
                                        <input type="checkbox" name="permisos[{{ $rol->ID_Rol }}][{{ $modulo }}][ver]" value="1"
                                            {{ $permiso['ver'] ? 'checked' : '' }}>
                                    </td>

                                    {{-- CREAR --}}
                                    <td class="border text-center">
                                        <input type="hidden" name="permisos[{{ $rol->ID_Rol }}][{{ $modulo }}][crear]" value="0">
                                        <input type="checkbox" name="permisos[{{ $rol->ID_Rol }}][{{ $modulo }}][crear]" value="1"
                                            {{ $permiso['crear'] ? 'checked' : '' }}>
                                    </td>

                                    {{-- EDITAR --}}
                                    <td class="border text-center">
                                        <input type="hidden" name="permisos[{{ $rol->ID_Rol }}][{{ $modulo }}][editar]" value="0">
                                        <input type="checkbox" name="permisos[{{ $rol->ID_Rol }}][{{ $modulo }}][editar]" value="1"
                                            {{ $permiso['editar'] ? 'checked' : '' }}>
                                    </td>

                                    {{-- ELIMINAR --}}
                                    <td class="border text-center">
                                        <input type="hidden" name="permisos[{{ $rol->ID_Rol }}][{{ $modulo }}][eliminar]" value="0">
                                        <input type="checkbox" name="permisos[{{ $rol->ID_Rol }}][{{ $modulo }}][eliminar]" value="1"
                                            {{ $permiso['eliminar'] ? 'checked' : '' }}>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 text-end">
                <button type="submit" style="background-color: #198754; color: white; padding: 10px 20px; border-radius: 6px;">
                    💾 Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</x-app-layout>




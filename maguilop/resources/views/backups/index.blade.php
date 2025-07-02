<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold flex items-center gap-2">
            <i class="fas fa-database"></i> Backups
        </h2>
    </x-slot>

    @php
        $permisos = \App\Helpers\PermisosHelper::class;
    @endphp

    <div class="p-4">
        {{-- Botón de crear backup --}}
        @if($permisos::tienePermiso('Backups', 'crear'))
            <a href="{{ route('backups.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow">
                <i class="fas fa-plus-circle"></i> Nuevo Backup
            </a>
        @endif

        <div class="overflow-x-auto bg-white rounded-lg shadow mt-4">
            <table class="min-w-full text-sm text-gray-800">
                <thead class="bg-orange-500 text-white text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Usuario</th>
                        <th class="px-4 py-3 text-left">Fecha</th>
                        <th class="px-4 py-3 text-left">Archivo</th>
                        <th class="px-4 py-3 text-left">Ruta</th>
                        <th class="px-4 py-3 text-left">Tamaño</th>
                        <th class="px-4 py-3 text-left">Descripción</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($backups as $backup)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $backup->BackupID }}</td>
                            <td class="px-4 py-2">{{ $backup->UsuarioID }}</td>
                            <td class="px-4 py-2">{{ $backup->FechaBackup }}</td>
                            <td class="px-4 py-2">{{ $backup->NombreArchivo }}</td>
                            <td class="px-4 py-2">{{ $backup->RutaArchivo }}</td>
                            <td class="px-4 py-2">{{ number_format($backup->TamanoMB, 2) }} MB</td>
                            <td class="px-4 py-2">{{ $backup->Descripcion }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Editar --}}
                                    @if($permisos::tienePermiso('Backups', 'editar'))
                                        <a href="{{ route('backups.edit', $backup->BackupID) }}"
                                           class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-full"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    {{-- Eliminar --}}
                                    @if($permisos::tienePermiso('Backups', 'eliminar'))
                                        <form action="{{ route('backups.destroy', $backup->BackupID) }}" method="POST"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este backup?')">
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

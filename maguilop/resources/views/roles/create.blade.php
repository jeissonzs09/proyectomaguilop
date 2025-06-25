<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">➕ Crear Rol</h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf

            {{-- Descripción --}}
            <div class="mb-4">
                <label for="Descripcion" class="block font-semibold mb-1">Descripción del Rol</label>
                <input type="text" name="Descripcion" id="Descripcion"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring"
                       value="{{ old('Descripcion') }}" required>
            </div>

            {{-- Estado --}}
            <div class="mb-4">
                <label for="Estado" class="block font-semibold mb-1">Estado</label>
                <select name="Estado" id="Estado"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring" required>
                    <option value="">-- Seleccione --</option>
                    <option value="Activo" {{ old('Estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                    <option value="Inactivo" {{ old('Estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            {{-- Botones --}}
            <div class="flex justify-between mt-6">
                <a href="{{ route('roles.index') }}"
                   style="background-color: #dc2626; color: white; padding: 10px 20px; border-radius: 8px;">
                    ← Cancelar
                </a>
                <button type="submit"
                        style="background-color: #2563eb; color: white; padding: 10px 20px; border-radius: 8px;">
                    💾 Guardar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

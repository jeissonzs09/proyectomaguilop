<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">👥 Nuevo Cliente</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf

          

            <div class="mb-4">
                <label for="NombreCliente" class="block text-gray-700 font-bold mb-2">Nombre del Cliente</label>
                <input type="text" name="NombreCliente" id="NombreCliente" placeholder="Ej: Juan Pérez"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="PersonaID" class="block text-gray-700 font-bold mb-2">Persona ID</label>
                <input type="number" name="PersonaID" id="PersonaID" placeholder="Ej: 201"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="Categoria" class="block text-gray-700 font-bold mb-2">Categoría</label>
                <input type="text" name="Categoria" id="Categoria" placeholder="Ej: Regular"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="FechaRegistro" class="block text-gray-700 font-bold mb-2">Fecha de Registro</label>
                <input type="date" name="FechaRegistro" id="FechaRegistro"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="Estado" class="block text-gray-700 font-bold mb-2">Estado</label>
                <select name="Estado" id="Estado" class="w-full border rounded px-3 py-2">
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>

            <div class="mb-6">
                <label for="Notas" class="block text-gray-700 font-bold mb-2">Notas</label>
                <textarea name="Notas" id="Notas" rows="3"
                    class="w-full border rounded px-3 py-2" placeholder="Notas adicionales"></textarea>
            </div>

           <div class="flex justify-between">
                <a href="{{ route('clientes.index') }}"
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    ❌ Cancelar
                </a>
                <button type="submit"
                        style="background-color: #2563eb; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); border: none;">
                    💾 Guardar Cliente
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
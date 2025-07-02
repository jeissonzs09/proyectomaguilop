<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🧑‍💼 Nuevo Empleado</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('empleados.store') }}" method="POST">
            @csrf


            <div class="mb-4">
                <label for="PersonaID" class="block text-gray-700 font-bold mb-2">Persona ID</label>
                <input type="number" name="PersonaID" id="PersonaID" placeholder="Ej: 101"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="Departamento" class="block text-gray-700 font-bold mb-2">Departamento</label>
                <input type="text" name="Departamento" id="Departamento" placeholder="Ej: Sistemas"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="Cargo" class="block text-gray-700 font-bold mb-2">Cargo</label>
                <input type="text" name="Cargo" id="Cargo" placeholder="Ej: Administrador"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="FechaContratacion" class="block text-gray-700 font-bold mb-2">Fecha de Contratación</label>
                <input type="date" name="FechaContratacion" id="FechaContratacion"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-6">
                <label for="Salario" class="block text-gray-700 font-bold mb-2">Salario (Lps.)</label>
                <input type="number" step="0.01" name="Salario" id="Salario" placeholder="Ej: 25000.00"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('empleados.index') }}"
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    ❌ Cancelar
                </a>
                <button type="submit"
                        style="background-color: #2563eb; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); border: none;">
                    💾 Guardar Empleado
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
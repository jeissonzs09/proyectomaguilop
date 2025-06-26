<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🛠️ Nueva Reparación</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('reparaciones.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="ClienteID" class="block text-gray-700 font-bold mb-2">Cliente ID</label>
                <input type="number" name="ClienteID" id="ClienteID" placeholder="Ej: 101"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="ProductoID" class="block text-gray-700 font-bold mb-2">Producto ID</label>
                <input type="number" name="ProductoID" id="ProductoID" placeholder="Ej: 2003"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="FechaEntrada" class="block text-gray-700 font-bold mb-2">Fecha de Entrada</label>
                <input type="date" name="FechaEntrada" id="FechaEntrada"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="FechaSalida" class="block text-gray-700 font-bold mb-2">Fecha de Salida</label>
                <input type="date" name="FechaSalida" id="FechaSalida"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="DescripcionProblema" class="block text-gray-700 font-bold mb-2">Descripción del Problema</label>
                <textarea name="DescripcionProblema" id="DescripcionProblema" rows="3"
                    class="w-full border rounded px-3 py-2" placeholder="Describa el problema del equipo" required></textarea>
            </div>

            <div class="mb-4">
                <label for="Estado" class="block text-gray-700 font-bold mb-2">Estado</label>
                <select name="Estado" id="Estado" class="w-full border rounded px-3 py-2">
                    <option value="Pendiente">Pendiente</option>
                    <option value="En proceso">En proceso</option>
                    <option value="Completado">Completado</option>
                </select>
            </div>

            <div class="mb-6">
                <label for="Costo" class="block text-gray-700 font-bold mb-2">Costo (Lps.)</label>
                <input type="number" step="0.01" name="Costo" id="Costo" placeholder="Ej: 1500.00"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('reparaciones.index') }}"
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    ❌ Cancelar
                </a>
                <button type="submit"
                        style="background-color: #2563eb; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); border: none;">
                    💾 Guardar Reparacion
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

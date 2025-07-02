<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold flex items-center gap-2">
            <i class="fas fa-tools"></i> Nueva Reparación
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('reparaciones.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="ClienteID" class="block font-semibold mb-1 text-gray-700">Cliente ID</label>
                <input type="number" name="ClienteID" id="ClienteID" placeholder="Ej: 101"
                       class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring focus:ring-indigo-200 focus:outline-none" required>
            </div>

            <div>
                <label for="ProductoID" class="block font-semibold mb-1 text-gray-700">Producto ID</label>
                <input type="number" name="ProductoID" id="ProductoID" placeholder="Ej: 2003"
                       class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring focus:ring-indigo-200 focus:outline-none" required>
            </div>

            <div>
                <label for="FechaEntrada" class="block font-semibold mb-1 text-gray-700">Fecha de Entrada</label>
                <input type="date" name="FechaEntrada" id="FechaEntrada"
                       class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring focus:ring-indigo-200 focus:outline-none" required>
            </div>

            <div>
                <label for="FechaSalida" class="block font-semibold mb-1 text-gray-700">Fecha de Salida</label>
                <input type="date" name="FechaSalida" id="FechaSalida"
                       class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring focus:ring-indigo-200 focus:outline-none">
            </div>

            <div>
                <label for="DescripcionProblema" class="block font-semibold mb-1 text-gray-700">Descripción del Problema</label>
                <textarea name="DescripcionProblema" id="DescripcionProblema" rows="3"
                          class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring focus:ring-indigo-200 focus:outline-none"
                          placeholder="Describa el problema del equipo" required></textarea>
            </div>

            <div>
                <label for="Estado" class="block font-semibold mb-1 text-gray-700">Estado</label>
                <select name="Estado" id="Estado"
                        class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring focus:ring-indigo-200 focus:outline-none">
                    <option value="Pendiente">Pendiente</option>
                    <option value="En proceso">En proceso</option>
                    <option value="Completado">Completado</option>
                </select>
            </div>

            <div>
                <label for="Costo" class="block font-semibold mb-1 text-gray-700">Costo (Lps.)</label>
                <input type="number" step="0.01" name="Costo" id="Costo" placeholder="Ej: 1500.00"
                       class="w-full border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring focus:ring-indigo-200 focus:outline-none" required>
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('reparaciones.index') }}"
                   class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded shadow inline-flex items-center gap-2">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow inline-flex items-center gap-2">
                    <i class="fas fa-save"></i> Guardar Reparación
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

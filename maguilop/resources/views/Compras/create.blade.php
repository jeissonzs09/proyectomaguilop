<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🛒 Nueva Compra</h2>
    </x-slot>

    <div class="p-6 max-w-3xl mx-auto bg-white shadow-md rounded-md">
        <form action="{{ route('compras.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="ProveedorID" class="block text-gray-700 font-semibold mb-2">Proveedor ID</label>
                <input type="number" name="ProveedorID" id="ProveedorID" placeholder="Ej: 1" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('ProveedorID') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="EmpleadoID" class="block text-gray-700 font-semibold mb-2">Empleado ID</label>
                <input type="number" name="EmpleadoID" id="EmpleadoID" placeholder="Ej: 12" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('EmpleadoID') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="FechaCompra" class="block text-gray-700 font-semibold mb-2">Fecha de Compra</label>
                <input type="datetime-local" name="FechaCompra" id="FechaCompra" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('FechaCompra') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="TotalCompra" class="block text-gray-700 font-semibold mb-2">Total de Compra (Lps.)</label>
                <input type="number" step="0.01" name="TotalCompra" id="TotalCompra" placeholder="Ej: 5000.00" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                @error('TotalCompra') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="Estado" class="block text-gray-700 font-semibold mb-2">Estado</label>
                <select name="Estado" id="Estado" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="Recibido">Recibido</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Cancelado">Cancelado</option>
                </select>
                @error('Estado') <p class="text-red-600 mt-1 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6 text-end">
                <a href="{{ route('compras.index') }}"
                   class="bg-red-600 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                   ❌ Cancelar
                </a>
                <button type="submit"
                        style="background-color: #2563eb; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); border: none;">
                    💾 Guardar Compra
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
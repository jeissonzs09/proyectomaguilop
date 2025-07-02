<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🛒 Editar Venta #{{ $venta->VentaID }}</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('ventas.update', $venta->VentaID) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="ClienteID" class="block text-gray-700 font-bold mb-2">Cliente ID</label>
                <input type="number" name="ClienteID" id="ClienteID" value="{{ old('ClienteID', $venta->ClienteID) }}" placeholder="Ej: 1"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="EmpleadoID" class="block text-gray-700 font-bold mb-2">Empleado ID</label>
                <input type="number" name="EmpleadoID" id="EmpleadoID" value="{{ old('EmpleadoID', $venta->EmpleadoID) }}" placeholder="Ej: 2"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="FechaVenta" class="block text-gray-700 font-bold mb-2">Fecha Venta</label>
                <input type="date" name="FechaVenta" id="FechaVenta" value="{{ old('FechaVenta', $venta->FechaVenta) }}"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="TotalVenta" class="block text-gray-700 font-bold mb-2">Total Venta</label>
                <input type="number" step="0.01" name="TotalVenta" id="TotalVenta" value="{{ old('TotalVenta', $venta->TotalVenta) }}" placeholder="Ej: 150.00"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('ventas.index') }}"
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    ❌ Cancelar
                </a>
                <button type="submit"
                        style="background-color: #2563eb; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); border: none;">
                    💾 Actualizar Venta
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
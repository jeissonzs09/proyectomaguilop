<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">📝 Nueva Factura</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('facturas.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="ClienteID" class="block text-gray-700 font-bold mb-2">Cliente ID</label>
                <input type="number" name="ClienteID" id="ClienteID" placeholder="Ej: 1"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="EmpleadoID" class="block text-gray-700 font-bold mb-2">Empleado ID</label>
                <input type="number" name="EmpleadoID" id="EmpleadoID" placeholder="Ej: 2"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="Fecha" class="block text-gray-700 font-bold mb-2">Fecha</label>
                <input type="date" name="Fecha" id="Fecha"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="Total" class="block text-gray-700 font-bold mb-2">Total (Lps.)</label>
                <input type="number" step="0.01" name="Total" id="Total" placeholder="Ej: 1500.00"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-6">
                <label for="detalles" class="block text-gray-700 font-bold mb-2">Detalles de la Factura</label>
                <div id="detalles" class="space-y-4">
                    <div class="detalle-item">
                        <input type="number" name="detalles[0][ProductoID]" placeholder="Producto ID" class="w-full border rounded px-3 py-2" required>
                        <input type="number" name="detalles[0][Cantidad]" placeholder="Cantidad" class="w-full border rounded px-3 py-2" required>
                        <input type="number" step="0.01" name="detalles[0][PrecioUnitario]" placeholder="Precio Unitario" class="w-full border rounded px-3 py-2" required>
                        <input type="number" step="0.01" name="detalles[0][Subtotal]" placeholder="Subtotal" class="w-full border rounded px-3 py-2" required>
                    </div>
                </div>
                <button type="button" onclick="addDetalle()" class="mt-2 text-blue-600">Agregar Detalle</button>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('facturas.index') }}"
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    ❌ Cancelar
                </a>
                <button type="submit"
                        style="background-color: #2563eb; color: white; font-weight: bold; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); border: none;">
                    💾 Guardar Factura
                </button>
            </div>
        </form>
    </div>

    <script>
        let detalleIndex = 1;
        function addDetalle() {
            const detalleHtml = `
                <div class="detalle-item">
                    <input type="number" name="detalles[${detalleIndex}][ProductoID]" placeholder="Producto ID" class="w-full border rounded px-3 py-2" required>
                    <input type="number" name="detalles[${detalleIndex}][Cantidad]" placeholder="Cantidad" class="w-full border rounded px-3 py-2" required>
                    <input type="number" step="0.01" name="detalles[${detalleIndex}][PrecioUnitario]" placeholder="Precio Unitario" class="w-full border rounded px-3 py-2" required>
                    <input type="number" step="0.01" name="detalles[${detalleIndex}][Subtotal]" placeholder="Subtotal" class="w-full border rounded px-3 py-2" required>
                </div>`;
            document.getElementById('detalles').insertAdjacentHTML('beforeend', detalleHtml);
            detalleIndex++;
        }
    </script>
</x-app-layout>
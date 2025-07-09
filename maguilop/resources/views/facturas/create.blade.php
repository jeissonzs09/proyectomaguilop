<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">📝 Nueva Factura</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('facturas.store') }}" method="POST">
            @csrf

            <!-- Cliente -->
            <div class="mb-4">
                <label for="ClienteID" class="block text-gray-700 font-bold mb-2">Cliente ID</label>
                <input type="number" name="ClienteID" id="ClienteID" placeholder="Ej: 1"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- Empleado -->
            <div class="mb-4">
                <label for="EmpleadoID" class="block text-gray-700 font-bold mb-2">Empleado ID</label>
                <input type="number" name="EmpleadoID" id="EmpleadoID" placeholder="Ej: 2"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- Fecha -->
            <div class="mb-4">
                <label for="Fecha" class="block text-gray-700 font-bold mb-2">Fecha</label>
                <input type="date" name="Fecha" id="Fecha"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- Total (calculado automáticamente) -->
            <div class="mb-4">
                <label for="Total" class="block text-gray-700 font-bold mb-2">Total (Lps.)</label>
                <input type="number" step="0.01" name="Total" id="Total" placeholder="Total automático"
                    class="w-full border rounded px-3 py-2 bg-gray-100" readonly required>
            </div>

            <!-- Detalles -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Detalles de la Factura</label>
                <div id="detalles" class="space-y-4">
                    <div class="detalle-item grid grid-cols-1 md:grid-cols-4 gap-2">
                        <input type="number" name="detalles[0][ProductoID]" placeholder="Producto ID" class="border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
                        <input type="number" name="detalles[0][Cantidad]" placeholder="Cantidad" class="border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
                        <input type="number" step="0.01" name="detalles[0][PrecioUnitario]" placeholder="Precio Unitario" class="border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
                        <input type="number" step="0.01" name="detalles[0][Subtotal]" placeholder="Subtotal" class="border rounded px-3 py-2 bg-gray-100" readonly required>
                    </div>
                </div>
                <button type="button" onclick="addDetalle()" class="mt-2 text-blue-600">➕ Agregar Detalle</button>
            </div>

            <!-- Botones -->
            <div class="flex justify-between">
                <a href="{{ route('facturas.index') }}"
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    ❌ Cancelar
                </a>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center gap-2">
                    💾 Guardar Factura
                </button>
            </div>
        </form>
    </div>

    <script>
        let detalleIndex = 1;

        function addDetalle() {
            const detalleHtml = `
                <div class="detalle-item grid grid-cols-1 md:grid-cols-4 gap-2 mt-2">
                    <input type="number" name="detalles[${detalleIndex}][ProductoID]" placeholder="Producto ID" class="border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
                    <input type="number" name="detalles[${detalleIndex}][Cantidad]" placeholder="Cantidad" class="border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
                    <input type="number" step="0.01" name="detalles[${detalleIndex}][PrecioUnitario]" placeholder="Precio Unitario" class="border rounded px-3 py-2" required oninput="calculateSubtotal(this)">
                    <input type="number" step="0.01" name="detalles[${detalleIndex}][Subtotal]" placeholder="Subtotal" class="border rounded px-3 py-2 bg-gray-100" readonly required>
                </div>`;
            document.getElementById('detalles').insertAdjacentHTML('beforeend', detalleHtml);
            detalleIndex++;
        }

        function calculateSubtotal(input) {
            const item = input.closest('.detalle-item');
            const cantidad = item.querySelector('input[name*="[Cantidad]"]').value;
            const precio = item.querySelector('input[name*="[PrecioUnitario]"]').value;
            const subtotal = item.querySelector('input[name*="[Subtotal]"]');
            subtotal.value = (cantidad * precio || 0).toFixed(2);
            updateTotal();
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('input[name*="[Subtotal]"]').forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            document.getElementById('Total').value = total.toFixed(2);
        }
    </script>
</x-app-layout>